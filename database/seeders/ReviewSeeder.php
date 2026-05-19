<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Mulai generate Reviews...');
        $faker = Faker::create('id_ID');

        // Ambil data enrollment yang completed
        $completedEnrollments = DB::table('enrollments')->where('status', 'completed')->get();
        if ($completedEnrollments->isEmpty()) {
            $this->command->warn('Tidak ada enrollment completed. Lewati review seeder.');
            return;
        }

        $reviews = [];
        $reviewId = 1;

        foreach ($completedEnrollments as $enrollment) {
            // 70% chance untuk memberi review
            if (rand(1, 10) <= 7) {
                // Hindari duplicate per user & course
                $exists = DB::table('reviews')
                    ->where('user_id', $enrollment->user_id)
                    ->where('course_id', $enrollment->course_id)
                    ->exists();

                if (!$exists) {
                    $reviews[] = [
                        'id' => $reviewId,
                        'user_id' => $enrollment->user_id,
                        'course_id' => $enrollment->course_id,
                        'rating' => rand(4, 5), // Asumsikan rating dominan 4-5
                        'comment' => $faker->sentence(10),
                        'is_visible' => 1,
                        'created_at' => $enrollment->updated_at,
                        'updated_at' => $enrollment->updated_at,
                    ];
                    $reviewId++;
                }
            }
        }

        $this->command->info('Menyimpan ' . count($reviews) . ' reviews...');
        foreach (array_chunk($reviews, 500) as $chunk) {
            DB::table('reviews')->insertOrIgnore($chunk);
        }

        $this->command->info('✅ Reviews seeded!');
    }
}
