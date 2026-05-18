<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Review::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // Ambil semua enrollment (prioritaskan yang completed, tapi include active juga)
        $enrollments = Enrollment::with(['user', 'course'])
            ->whereIn('status', ['completed', 'active'])
            ->where('progress_percent', '>=', 30) // minimal 30% progress untuk bisa review
            ->get();

        if ($enrollments->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada enrollment untuk di-review.');
            return;
        }

        $positiveComments = [
            'Kursus yang sangat membantu! Penjelasan mudah dipahami dan materinya sangat terstruktur dengan baik.',
            'Materi lengkap dan instrukturnya sangat responsif terhadap setiap pertanyaan yang diajukan.',
            'Recommended banget untuk pemula. Saya bisa langsung praktek setelah belajar materi ini.',
            'Kualitas video dan materi sangat bagus. Worth every penny! Sangat puas.',
            'Instruktur menjelaskan dengan sangat detail dan sabar. Belajar jadi menyenangkan.',
            'Salah satu kursus terbaik yang pernah saya ikuti. Materi up-to-date dan relevan.',
            'Penjelasan sangat clear dan mudah diikuti walaupun saya pemula. Sangat direkomendasikan!',
            'Kursus ini benar-benar mengubah cara saya berpikir tentang pemrograman. Luar biasa!',
            'Konten berkualitas tinggi dengan harga yang sangat terjangkau. Sangat worth it!',
            'Saya sudah mengikuti banyak kursus online, ini yang terbaik sejauh ini.',
        ];

        $neutralComments = [
            'Materi cukup bagus secara keseluruhan, tapi ada beberapa bagian yang perlu diperjelas lagi.',
            'Kursus ini oke, materinya cukup lengkap. Bisa lebih baik jika ada latihan soal lebih banyak.',
            'Penjelasan instruktur lumayan mudah dipahami. Harapannya ada update materi yang lebih baru.',
            'Cukup informatif dan membantu untuk memulai. Masih ada ruang untuk perbaikan.',
            'Materi dasarnya bagus, namun saya berharap ada bagian advanced yang lebih mendalam.',
        ];

        $negativeComments = [
            'Materi kurang mendalam untuk level intermediate. Perlu ditambah lebih banyak praktik.',
            'Beberapa penjelasan kurang jelas dan butuh contoh yang lebih konkret.',
            'Kecepatan instruktur terlalu cepat di beberapa bagian. Harap diperlambat.',
        ];

        $batch    = [];
        $inserted = 0;
        $limit    = min(500, $enrollments->count()); // maksimal 500 review

        $this->command->info("Generating reviews untuk {$limit} enrollments...");

        $selectedEnrollments = $enrollments->random($limit);

        foreach ($selectedEnrollments as $enrollment) {
            // Distribusi rating: kebanyakan positif
            $roll = rand(1, 10);
            if ($roll <= 6) {
                // 60% rating 5
                $rating  = 5;
                $comment = $positiveComments[array_rand($positiveComments)];
            } elseif ($roll <= 9) {
                // 30% rating 4
                $rating  = 4;
                $comment = $roll <= 7 ? $positiveComments[array_rand($positiveComments)] : $neutralComments[array_rand($neutralComments)];
            } else {
                // 10% rating 1-3
                $rating  = rand(1, 3);
                $comment = $rating >= 3 ? $neutralComments[array_rand($neutralComments)] : $negativeComments[array_rand($negativeComments)];
            }

            $reviewDate = now()->subDays(rand(1, 120));

            $batch[] = [
                'user_id'    => $enrollment->user_id,
                'course_id'  => $enrollment->course_id,
                'rating'     => $rating,
                'comment'    => $comment,
                'is_visible' => true,
                'created_at' => $reviewDate,
                'updated_at' => $reviewDate,
            ];

            $inserted++;

            if (count($batch) === 100) {
                DB::table('reviews')->insertOrIgnore($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            DB::table('reviews')->insertOrIgnore($batch);
        }

        $this->command->info('✅ Reviews seeded: ' . DB::table('reviews')->count() . ' records');
    }
}
