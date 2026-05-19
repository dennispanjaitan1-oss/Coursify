<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Enrollment;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $enrollments = Enrollment::with(['user', 'course'])->take(5)->get();

        $comments = [
            'Kursus yang sangat membantu! Penjelasan mudah dipahami dan materinya terstruktur.',
            'Materi lengkap dan instrukturnya sangat responsif terhadap pertanyaan.',
            'Recommended untuk pemula. Saya bisa langsung praktek setelah belajar.',
            'Kualitas video dan materi sangat bagus. Worth the price!',
            'Instruktur menjelaskan dengan sangat detail. Belajar jadi menyenangkan.',
        ];

        foreach ($enrollments as $index => $enroll) {
            Review::firstOrCreate([
                'user_id' => $enroll->user_id,
                'course_id' => $enroll->course_id,
            ], [
                'rating' => fake()->numberBetween(4, 5),
                'comment' => $comments[$index] ?? fake()->sentence(10),
                'created_at' => now()->subHours(rand(2, 72)),
                'updated_at' => now()->subHours(rand(1, 48)),
            ]);
        }
    }
}
