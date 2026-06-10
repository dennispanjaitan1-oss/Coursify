<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Menambahkan sample kuis untuk beberapa kursus...');

        $courseIds = DB::table('courses')->pluck('id')->take(5);
        if ($courseIds->isEmpty()) {
            $this->command->warn('Tidak ada kursus tersedia untuk ditambahkan kuis.');
            return;
        }

        $quizTemplates = [
            [
                'lesson_title' => 'Kuis Akhir Bagian 1',
                'questions' => [
                    [
                        'question' => 'Apa tujuan utama kursus ini?',
                        'type' => 'multiple_choice',
                        'options' => [
                            ['option_text' => 'Memahami konsep utama kursus', 'is_correct' => true],
                            ['option_text' => 'Mendaftar kursus baru', 'is_correct' => false],
                            ['option_text' => 'Melihat harga kursus', 'is_correct' => false],
                            ['option_text' => 'Belajar membuat kuis', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Apakah materi ini menekankan praktik nyata?',
                        'type' => 'true_false',
                        'options' => [
                            ['option_text' => 'Benar', 'is_correct' => true],
                            ['option_text' => 'Salah', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Langkah terbaik berikutnya setelah menyelesaikan bagian ini adalah?',
                        'type' => 'multiple_choice',
                        'options' => [
                            ['option_text' => 'Melanjutkan ke bagian berikutnya', 'is_correct' => true],
                            ['option_text' => 'Mengulang kursus dari awal', 'is_correct' => false],
                            ['option_text' => 'Membatalkan pendaftaran', 'is_correct' => false],
                            ['option_text' => 'Mencetak sertifikat sekarang', 'is_correct' => false],
                        ],
                    ],
                ],
            ],
            [
                'lesson_title' => 'Kuis Konsep Utama',
                'questions' => [
                    [
                        'question' => 'Materi ini paling banyak membahas tentang apa?',
                        'type' => 'multiple_choice',
                        'options' => [
                            ['option_text' => 'Konsep utama dan istilah penting', 'is_correct' => true],
                            ['option_text' => 'Sejarah kursus', 'is_correct' => false],
                            ['option_text' => 'Harga dan pembayaran', 'is_correct' => false],
                            ['option_text' => 'Bimbingan karir', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Apakah kamu akan menggunakan pengetahuan ini dalam tugas praktik?',
                        'type' => 'true_false',
                        'options' => [
                            ['option_text' => 'Benar', 'is_correct' => true],
                            ['option_text' => 'Salah', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Cara terbaik untuk menyiapkan diri sebelum melanjutkan ke bab berikutnya adalah?',
                        'type' => 'multiple_choice',
                        'options' => [
                            ['option_text' => 'Mengulang poin penting dan menjawab kuis', 'is_correct' => true],
                            ['option_text' => 'Langsung lompat ke bab selanjutnya', 'is_correct' => false],
                            ['option_text' => 'Menunggu instruktur memberi nilai', 'is_correct' => false],
                            ['option_text' => 'Mencari kursus lain', 'is_correct' => false],
                        ],
                    ],
                ],
            ],
        ];

        $courseCount = 0;
        foreach ($courseIds as $courseId) {
            $section = DB::table('sections')
                ->where('course_id', $courseId)
                ->orderBy('order_index')
                ->first();

            if (! $section) {
                continue;
            }

            $maxOrderIndex = DB::table('lessons')
                ->where('section_id', $section->id)
                ->max('order_index') ?: 0;

            $template = $quizTemplates[array_rand($quizTemplates)];

            $lessonId = DB::table('lessons')->insertGetId([
                'section_id' => $section->id,
                'title' => $template['lesson_title'],
                'type' => 'quiz',
                'duration_seconds' => 0,
                'order_index' => $maxOrderIndex + 1,
                'is_free_preview' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($template['questions'] as $questionIndex => $questionData) {
                $quizId = DB::table('quizzes')->insertGetId([
                    'lesson_id' => $lessonId,
                    'question' => $questionData['question'],
                    'type' => $questionData['type'],
                    'order_index' => $questionIndex + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($questionData['options'] as $optionData) {
                    DB::table('quiz_options')->insert([
                        'quiz_id' => $quizId,
                        'option_text' => $optionData['option_text'],
                        'is_correct' => $optionData['is_correct'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            $courseCount++;
        }

        $this->command->info("✅ Quiz seeded untuk {$courseCount} kursus.");
    }
}
