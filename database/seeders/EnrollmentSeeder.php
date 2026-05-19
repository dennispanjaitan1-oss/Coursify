<?php

namespace Database\Seeders;
 
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
 
class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')->get();
        $courses  = Course::where('is_published', true)->with('sections.lessons')->get();
 
        // Pastikan student default ter-enroll
        $defaultStudent = User::where('email', 'student@coursify.com')->first();
        $this->enrollStudent($defaultStudent, $courses->take(4));
 
        // Enroll random student ke random courses
        foreach ($students->take(20) as $student) {
            $randomCourses = $courses->random(rand(1, 4));
            $this->enrollStudent($student, $randomCourses);
        }
    }
 
    private function enrollStudent(User $student, $courses): void
    {
        foreach ($courses as $course) {
            // Skip jika sudah enrolled
            if (Enrollment::where('user_id', $student->id)
                          ->where('course_id', $course->id)
                          ->exists()) {
                continue;
            }
 
            // Buat payment
            $payment = Payment::create([
                'user_id' => $student->id,
                'amount'  => $course->price,
                'method'  => $course->price == 0 ? 'free' : 'transfer_bank',
                'status'  => 'paid',
                'paid_at' => now()->subDays(rand(1, 90)),
            ]);
 
            // Progress: 0%, 50%, atau 100%
            $progressLevel = rand(0, 2); // 0=belum, 1=setengah, 2=selesai
 
            $progressPercent = match($progressLevel) {
                0 => rand(0, 10),
                1 => rand(30, 70),
                2 => 100,
            };
 
            $enrollment = Enrollment::create([
                'user_id'          => $student->id,
                'course_id'        => $course->id,
                'payment_id'       => $payment->id,
                'type'             => $course->price == 0 ? 'audit' : 'verified',
                'status'           => $progressPercent >= 100 ? 'completed' : 'active',
                'progress_percent' => $progressPercent,
                'completed_at'     => $progressPercent >= 100 ? now()->subDays(rand(1, 30)) : null,
            ]);
 
            // Buat lesson progress sesuai persentase
            $allLessons = $course->sections->flatMap->lessons;
            if ($allLessons->isEmpty()) continue;
 
            $totalLessons    = $allLessons->count();
            $completedCount  = (int) ($totalLessons * $progressPercent / 100);
 
            foreach ($allLessons->take($completedCount) as $lesson) {
                LessonProgress::firstOrCreate(
                    ['user_id' => $student->id, 'lesson_id' => $lesson->id],
                    [
                        'is_completed'          => true,
                        'last_position_seconds' => $lesson->duration_seconds,
                    ]
                );
            }
        }
    }
}
