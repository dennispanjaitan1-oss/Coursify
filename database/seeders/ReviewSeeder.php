<?php

namespace Database\Seeders;
 
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
 
class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $komentar = [
            5 => [
                'Kursus terbaik yang pernah saya ikuti! Penjelasannya sangat jelas dan mudah dipahami.',
                'Instrukturnya sangat berpengalaman. Materi disajikan secara sistematis dan terstruktur.',
                'Sangat merekomendasikan kursus ini untuk siapapun yang ingin belajar dari nol!',
                'Luar biasa! Dalam waktu singkat saya sudah bisa membuat proyek nyata.',
                'Worth it banget! Materi lengkap, instruktur responsif, komunitas aktif.',
            ],
            4 => [
                'Kursus yang sangat bagus. Materi lengkap dan mudah diikuti.',
                'Penjelasan cukup detail. Ada beberapa bagian yang perlu diperdalam tapi overall bagus.',
                'Bagus untuk pemula. Saya jadi lebih percaya diri setelah menyelesaikan kursus ini.',
                'Konten berkualitas, harga sangat worth it. Recommended!',
                'Materi up-to-date dan relevan dengan kebutuhan industri saat ini.',
            ],
            3 => [
                'Kursus cukup baik, tapi beberapa materi terlalu cepat dijelaskan.',
                'Oke untuk level pemula, tapi butuh lebih banyak latihan praktis.',
                'Materi bagus tapi kualitas video bisa ditingkatkan.',
                'Cukup membantu, meski ada beberapa topik yang kurang mendalam.',
            ],
        ];
 
        // Review untuk semua enrollment yang sudah selesai atau progress > 50%
        $enrollments = Enrollment::where(function ($q) {
            $q->where('status', 'completed')
              ->orWhere('progress_percent', '>', 50);
        })->get();
 
        foreach ($enrollments as $enrollment) {
            // 80% kemungkinan memberikan review
            if (rand(1, 10) > 8) continue;
 
            $rating = match(true) {
                rand(0, 10) > 7 => 5,
                rand(0, 10) > 4 => 4,
                default         => 3,
            };
 
            Review::firstOrCreate(
                [
                    'user_id'   => $enrollment->user_id,
                    'course_id' => $enrollment->course_id,
                ],
                [
                    'rating'     => $rating,
                    'comment'    => $komentar[$rating][array_rand($komentar[$rating])],
                    'is_visible' => true,
                ]
            );
 
            // Generate sertifikat untuk yang sudah selesai 100%
            if ($enrollment->status === 'completed') {
                Certificate::firstOrCreate(
                    [
                        'user_id'   => $enrollment->user_id,
                        'course_id' => $enrollment->course_id,
                    ],
                    [
                        'certificate_number' => 'CERT-' . date('Y') . '-' . strtoupper(Str::random(8)),
                        'issued_at'          => $enrollment->completed_at ?? now(),
                    ]
                );
            }
        }
    }
}
