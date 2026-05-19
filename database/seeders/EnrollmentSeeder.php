<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\User;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Mulai generate Enrollments, Payments, dan Lesson Progress...');
        
        $students = DB::table('users')->where('role', 'student')->get();
        if ($students->isEmpty()) {
            $this->command->warn('Tidak ada akun student. Lewati enrollment seeder.');
            return;
        }

        $courses = DB::table('courses')->where('is_published', 1)->get();
        if ($courses->isEmpty()) {
            $this->command->warn('Tidak ada course. Lewati enrollment seeder.');
            return;
        }

        $payments = [];
        $paymentItems = [];
        $enrollments = [];
        $lessonProgress = [];

        $paymentId = 1;
        $enrollmentId = 1;

        foreach ($students as $student) {
            // Tiap student enroll di 4 kursus acak (200 x 4 = 800 enrollments)
            $randomCourses = $courses->random(4);

            foreach ($randomCourses as $course) {
                $isFree = $course->price == 0;
                $isCompleted = rand(0, 1); // 50% chance completed
                $paymentMethod = $isFree ? 'free' : collect(['transfer_bank', 'gopay', 'ovo', 'dana'])->random();
                $paidAt = now()->subDays(rand(1, 60));

                // Payment
                $payments[] = [
                    'id' => $paymentId,
                    'user_id' => $student->id,
                    'amount' => $isFree ? 0 : $course->price,
                    'method' => $paymentMethod,
                    'status' => 'paid',
                    'transaction_id' => 'TXN-' . strtoupper(uniqid()),
                    'paid_at' => $paidAt,
                    'created_at' => $paidAt,
                    'updated_at' => $paidAt,
                ];

                // Payment Item
                $paymentItems[] = [
                    'payment_id' => $paymentId,
                    'course_id' => $course->id,
                    'item_type' => 'course',
                    'price' => $isFree ? 0 : $course->price,
                    'created_at' => $paidAt,
                    'updated_at' => $paidAt,
                ];

                // Enrollment
                $enrollments[] = [
                    'id' => $enrollmentId,
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                    'payment_id' => $paymentId,
                    'type' => $isFree ? 'audit' : 'verified',
                    'status' => $isCompleted ? 'completed' : 'active',
                    'progress_percent' => $isCompleted ? 100 : rand(10, 80),
                    'completed_at' => $isCompleted ? $paidAt->copy()->addDays(5) : null,
                    'created_at' => $paidAt,
                    'updated_at' => $isCompleted ? $paidAt->copy()->addDays(5) : $paidAt,
                ];

                // Lesson Progress (Ambil lesson dari course ini)
                $lessons = DB::table('lessons')
                    ->join('sections', 'lessons.section_id', '=', 'sections.id')
                    ->where('sections.course_id', $course->id)
                    ->select('lessons.id')
                    ->get();

                $lessonsToComplete = $isCompleted ? $lessons->count() : max(1, (int)($lessons->count() * 0.5));
                $count = 0;

                foreach ($lessons as $lesson) {
                    if ($count >= $lessonsToComplete) break;
                    
                    $lessonProgress[] = [
                        'user_id' => $student->id,
                        'lesson_id' => $lesson->id,
                        'is_completed' => 1,
                        'created_at' => $paidAt->copy()->addHours($count),
                        'updated_at' => $paidAt->copy()->addHours($count),
                    ];
                    $count++;
                }

                $paymentId++;
                $enrollmentId++;
            }
        }

        $this->command->info('Menyimpan ' . count($payments) . ' payments...');
        foreach (array_chunk($payments, 500) as $chunk) {
            DB::table('payments')->insertOrIgnore($chunk);
        }

        $this->command->info('Menyimpan ' . count($paymentItems) . ' payment_items...');
        foreach (array_chunk($paymentItems, 500) as $chunk) {
            DB::table('payment_items')->insertOrIgnore($chunk);
        }

        $this->command->info('Menyimpan ' . count($enrollments) . ' enrollments...');
        foreach (array_chunk($enrollments, 500) as $chunk) {
            DB::table('enrollments')->insertOrIgnore($chunk);
        }

        $this->command->info('Menyimpan ' . count($lessonProgress) . ' lesson_progress...');
        foreach (array_chunk($lessonProgress, 1000) as $chunk) {
            DB::table('lesson_progress')->insertOrIgnore($chunk);
        }

        $this->command->info('✅ Enrollments & Payments seeded!');
    }
}
