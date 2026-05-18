<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        LessonProgress::truncate();
        Enrollment::truncate();
        Payment::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $students = User::where('role', 'student')->get();
        $courses  = Course::where('is_published', true)->with('sections.lessons')->get();

        if ($courses->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada kursus published. Jalankan CourseSeeder dulu.');
            return;
        }

        $this->command->info("Enrolling {$students->count()} students ke {$courses->count()} courses...");

        // Pastikan student demo ter-enroll ke 4 kursus pertama
        $defaultStudent = User::where('email', 'student@coursify.com')->first();
        if ($defaultStudent) {
            $this->enrollStudent($defaultStudent, $courses->take(4));
        }

        $progressBar = $this->command->getOutput()->createProgressBar($students->count());
        $progressBar->start();

        foreach ($students as $student) {
            // Setiap student enroll ke 2-6 kursus acak
            $count         = rand(2, min(6, $courses->count()));
            $randomCourses = $courses->random($count);
            $this->enrollStudent($student, $randomCourses);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->newLine();

        $this->command->info('✅ Enrollments seeded: ' . DB::table('enrollments')->count() . ' records');
        $this->command->info('✅ Payments seeded:     ' . DB::table('payments')->count() . ' records');
        $this->command->info('✅ LessonProgress:      ' . DB::table('lesson_progress')->count() . ' records');
    }

    private function enrollStudent(User $student, $courses): void
    {
        $paymentMethods = ['transfer_bank', 'gopay', 'ovo', 'dana', 'qris', 'kartu_kredit'];

        foreach ($courses as $course) {
            // Skip jika sudah enrolled
            if (Enrollment::where('user_id', $student->id)
                          ->where('course_id', $course->id)
                          ->exists()) {
                continue;
            }

            // Tentukan progress level: 0=belum mulai, 1=setengah jalan, 2=selesai
            $progressLevel   = rand(0, 2);
            $progressPercent = match ($progressLevel) {
                0 => rand(0, 5),
                1 => rand(20, 80),
                2 => 100,
            };

            $paidAt    = now()->subDays(rand(1, 180));
            $isPaid    = (rand(1, 10) <= 9); // 90% sukses
            $isFree    = $course->price == 0;
            $method    = $isFree ? 'free' : $paymentMethods[array_rand($paymentMethods)];

            // Buat payment record
            $payment = Payment::create([
                'user_id'        => $student->id,
                'amount'         => $isFree ? 0 : $course->price,
                'currency'       => 'IDR',
                'method'         => $method,
                'status'         => $isPaid ? 'paid' : ($isFree ? 'paid' : 'pending'),
                'transaction_id' => $isFree ? null : strtoupper('TXN-' . uniqid()),
                'paid_at'        => ($isPaid || $isFree) ? $paidAt : null,
                'created_at'     => $paidAt,
                'updated_at'     => $paidAt,
            ]);

            // Buat enrollment
            $completedAt = $progressPercent >= 100 ? $paidAt->copy()->addDays(rand(7, 60)) : null;

            $enrollment = Enrollment::create([
                'user_id'          => $student->id,
                'course_id'        => $course->id,
                'payment_id'       => $payment->id,
                'type'             => $isFree ? 'audit' : 'verified',
                'status'           => $progressPercent >= 100 ? 'completed' : 'active',
                'progress_percent' => $progressPercent,
                'completed_at'     => $completedAt,
                'created_at'       => $paidAt,
                'updated_at'       => $completedAt ?? $paidAt,
            ]);

            // Buat lesson progress sesuai persentase
            $allLessons    = $course->sections->flatMap->lessons;
            $totalLessons  = $allLessons->count();
            if ($totalLessons === 0) continue;

            $completedCount = (int) ($totalLessons * $progressPercent / 100);

            $progressBatch = [];
            foreach ($allLessons->take($completedCount) as $lesson) {
                $lessonDate = $paidAt->copy()->addDays(rand(0, 30));
                $progressBatch[] = [
                    'user_id'               => $student->id,
                    'lesson_id'             => $lesson->id,
                    'is_completed'          => true,
                    'last_position_seconds' => $lesson->duration_seconds ?? 0,
                    'created_at'            => $lessonDate,
                    'updated_at'            => $lessonDate,
                ];
            }

            if (!empty($progressBatch)) {
                // insertOrIgnore untuk hindari duplikasi
                DB::table('lesson_progress')->insertOrIgnore($progressBatch);
            }
        }
    }
}
