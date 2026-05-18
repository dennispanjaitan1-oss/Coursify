<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\User;
use App\Events\NewEnrollment;

class EnrollmentService
{
    /**
     * Handle enrollment for a free course.
     */
    public function enrollFreeCourse(User $user, Course $course): Enrollment
    {
        $payment = Payment::create([
            'user_id' => $user->id,
            'amount'  => 0,
            'method'  => 'free',
            'status'  => 'paid',
            'paid_at' => now(),
        ]);

        $enrollment = Enrollment::create([
            'user_id'    => $user->id,
            'course_id'  => $course->id,
            'payment_id' => $payment->id,
            'type'       => 'audit',
            'status'     => 'active',
        ]);

        broadcast(new NewEnrollment($enrollment));

        return $enrollment;
    }

    /**
     * Toggle a course in the user's wishlist.
     */
    public function toggleWishlist(User $user, Course $course): string
    {
        $wishlist = Wishlist::where('user_id', $user->id)
                            ->where('course_id', $course->id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return 'Dihapus dari wishlist.';
        }

        Wishlist::create(['user_id' => $user->id, 'course_id' => $course->id]);
        return 'Ditambahkan ke wishlist!';
    }

    /**
     * Verify if the user has completed 100% of the course.
     */
    public function canSubmitReview(User $user, Course $course): bool
    {
        $totalLessons = $course->sections()->withCount('lessons')->get()->sum('lessons_count');
        $completedLessons = $user->lessonProgress()
            ->whereHas('lesson.section', fn($q) => $q->where('course_id', $course->id))
            ->where('is_completed', true)
            ->count();

        return !($totalLessons > 0 && $completedLessons < $totalLessons);
    }

    /**
     * Submit or update a review for a course.
     */
    public function submitReview(User $user, Course $course, int $rating, string $comment): Review
    {
        return Review::updateOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            [
                'rating'     => $rating,
                'comment'    => $comment,
                'is_visible' => true,
            ]
        );
    }

    /**
     * Handle unenrollment logic.
     */
    public function unenroll(User $user, Enrollment $enrollment): bool
    {
        if ($enrollment->user_id !== $user->id) {
            return false;
        }

        $enrollment->delete();
        return true;
    }
}
