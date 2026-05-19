<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use Faker\Factory as Faker;

class CourseContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Mulai generate Sections & Lessons untuk 1000 courses...');
        $faker = Faker::create('id_ID');

        // Ambil semua course id
        $courseIds = DB::table('courses')->pluck('id')->toArray();
        if (empty($courseIds)) {
            $this->command->warn('Tidak ada course ditemukan.');
            return;
        }

        $sections = [];
        $lessons = [];
        $sectionId = 1;
        $lessonId = 1;

        foreach ($courseIds as $courseId) {
            // Tiap course kita beri 2 section
            for ($s = 1; $s <= 2; $s++) {
                $sections[] = [
                    'id' => $sectionId,
                    'course_id' => $courseId,
                    'title' => 'Bagian ' . $s . ': ' . $faker->sentence(3),
                    'order_index' => $s,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Tiap section beri 2 lesson (jadi total 4 lesson per course)
                for ($l = 1; $l <= 2; $l++) {
                    $lessons[] = [
                        'id' => $lessonId,
                        'section_id' => $sectionId,
                        'title' => 'Materi ' . $s . '.' . $l . ': ' . $faker->sentence(4),
                        'type' => 'video',
                        'duration_seconds' => rand(180, 1200), // 3-20 menit
                        'order_index' => $l,
                        'is_free_preview' => ($s == 1 && $l == 1) ? 1 : 0, // lesson pertama free
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $lessonId++;
                }
                $sectionId++;
            }
        }

        // Insert in chunks agar memory aman
        $this->command->info('Menyimpan ' . count($sections) . ' sections...');
        foreach (array_chunk($sections, 1000) as $chunk) {
            DB::table('sections')->insertOrIgnore($chunk);
        }

        $this->command->info('Menyimpan ' . count($lessons) . ' lessons...');
        foreach (array_chunk($lessons, 1000) as $chunk) {
            DB::table('lessons')->insertOrIgnore($chunk);
        }

        $this->command->info('✅ Course Content seeded!');
    }
}
