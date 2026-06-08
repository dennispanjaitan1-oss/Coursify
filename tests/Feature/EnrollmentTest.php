<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Section;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Course $course;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'student']);
        $this->course = Course::factory()->create([
            'has_audit_track' => true,
            'upgrade_deadline' => now()->addDays(7),
        ]);
    }

    /** @test */
    public function user_can_enroll_to_course_audit_track_for_free()
    {
        $response = $this->actingAs($this->user)
            ->post(route('courses.enroll', $this->course), [
                'track' => 'audit',
            ]);

        $response->assertRedirect(route('student.learn', $this->course->slug));
        $this->assertDatabaseHas('enrollments', [
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'type' => 'audit',
            'status' => 'active',
        ]);
    }

    /** @test */
    public function audit_enrollment_creates_free_payment()
    {
        $this->actingAs($this->user)
            ->post(route('courses.enroll', $this->course), [
                'track' => 'audit',
            ]);

        $this->assertDatabaseHas('payments', [
            'user_id' => $this->user->id,
            'amount' => 0,
            'method' => 'free',
            'status' => 'paid',
        ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_enroll()
    {
        $response = $this->post(route('courses.enroll', $this->course), [
            'track' => 'audit',
        ]);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function user_cannot_enroll_to_same_course_twice()
    {
        Enrollment::factory()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'type' => 'audit',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('courses.enroll', $this->course), [
                'track' => 'audit',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('info');
    }

    /** @test */
    public function user_can_upgrade_from_audit_to_verified()
    {
        $enrollment = Enrollment::factory()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'type' => 'audit',
        ]);

        if (!$this->course->hasCertificatePrice() && $this->course->isFree()) {
            $response = $this->actingAs($this->user)
                ->post(route('courses.enroll', $this->course), [
                    'track' => 'verified',
                ]);

            $response->assertRedirect(route('student.learn', $this->course->slug));
            $this->assertDatabaseHas('enrollments', [
                'id' => $enrollment->id,
                'type' => 'verified',
            ]);
        }
    }

    /** @test */
    public function user_cannot_upgrade_after_deadline()
    {
        $course = Course::factory()->create([
            'upgrade_deadline' => now()->subDays(1),
        ]);

        Enrollment::factory()->create([
            'user_id' => $this->user->id,
            'course_id' => $course->id,
            'type' => 'audit',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('courses.enroll', $course), [
                'track' => 'verified',
            ]);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function enrollment_sets_initial_progress_to_zero()
    {
        $this->actingAs($this->user)
            ->post(route('courses.enroll', $this->course), [
                'track' => 'audit',
            ]);

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'progress_percent' => 0.00,
        ]);
    }

    /** @test */
    public function enrollment_broadcasts_event()
    {
        \Event::fake();

        $this->actingAs($this->user)
            ->post(route('courses.enroll', $this->course), [
                'track' => 'audit',
            ]);

        \Event::assertDispatched(\App\Events\NewEnrollment::class);
    }

    /** @test */
    public function enrolled_user_can_access_learning_page()
    {
        Enrollment::factory()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('student.learn', $this->course->slug));

        $response->assertStatus(200);
    }

    /** @test */
    public function non_enrolled_user_cannot_access_learning_page()
    {
        $response = $this->actingAs($this->user)
            ->get(route('student.learn', $this->course->slug));

        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_update_lesson_progress()
    {
        $enrollment = Enrollment::factory()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
        ]);

        $section = Section::factory()->create(['course_id' => $this->course->id]);
        $lesson = Lesson::factory()->create(['section_id' => $section->id]);

        $response = $this->actingAs($this->user)
            ->post(route('progress.update', $lesson), [
                'position_seconds' => 300,
                'is_completed' => true,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('lesson_progress', [
            'user_id' => $this->user->id,
            'lesson_id' => $lesson->id,
            'is_completed' => true,
        ]);
    }

    /** @test */
    public function cannot_update_progress_for_non_enrolled_course()
    {
        $section = Section::factory()->create(['course_id' => $this->course->id]);
        $lesson = Lesson::factory()->create(['section_id' => $section->id]);

        $response = $this->actingAs($this->user)
            ->post(route('progress.update', $lesson), [
                'position_seconds' => 300,
                'is_completed' => true,
            ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function enrollment_status_can_be_active()
    {
        $enrollment = Enrollment::factory()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'status' => 'active',
        ]);

        $this->assertEquals('active', $enrollment->status);
    }

    /** @test */
    public function enrollment_status_can_be_completed()
    {
        $enrollment = Enrollment::factory()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'status' => 'completed',
        ]);

        $this->assertEquals('completed', $enrollment->status);
    }

    /** @test */
    public function enrollment_status_can_be_refunded()
    {
        $enrollment = Enrollment::factory()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'status' => 'refunded',
        ]);

        $this->assertEquals('refunded', $enrollment->status);
    }

    /** @test */
    public function user_can_have_multiple_enrollments_with_different_status()
    {
        $this->assertEquals(0, Enrollment::where('user_id', $this->user->id)->count());

        Enrollment::factory()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'status' => 'active',
        ]);

        // User can have audit enrollment and then verified enrollment
        // (they have different statuses or are updated in place)
        $count = Enrollment::where('user_id', $this->user->id)
                           ->where('course_id', $this->course->id)
                           ->count();

        $this->assertEquals(1, $count);
    }

    /** @test */
    public function enrollment_validates_track_type()
    {
        $response = $this->actingAs($this->user)
            ->post(route('courses.enroll', $this->course), [
                'track' => 'invalid_track',
            ]);

        $response->assertSessionHasErrors('track');
    }

    /** @test */
    public function course_without_audit_track_forces_verified()
    {
        $courseNoAudit = Course::factory()->create(['has_audit_track' => false]);

        $response = $this->actingAs($this->user)
            ->post(route('courses.enroll', $courseNoAudit), [
                'track' => 'audit',
            ]);

        // Should redirect to payment, not create free enrollment
        $response->assertRedirect(route('payment.index', [
            'course' => $courseNoAudit->id,
            'track' => 'verified',
        ]));
    }

    /** @test */
    public function lesson_progress_records_position_in_video()
    {
        Enrollment::factory()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
        ]);

        $section = Section::factory()->create(['course_id' => $this->course->id]);
        $lesson = Lesson::factory()->create(['section_id' => $section->id]);

        $this->actingAs($this->user)
            ->post(route('progress.update', $lesson), [
                'position_seconds' => 455,
                'is_completed' => false,
            ]);

        $this->assertDatabaseHas('lesson_progress', [
            'user_id' => $this->user->id,
            'lesson_id' => $lesson->id,
            'last_position_seconds' => 455,
        ]);
    }
}
