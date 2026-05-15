<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan data lama untuk menghindari duplikasi ID
        Schema::disableForeignKeyConstraints();
        Course::truncate();
        DB::table('course_instructors')->truncate();
        Section::truncate();
        Lesson::truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Import Kursus dari CSV
        $coursesCsv = database_path('data/csv/courses_raw.csv');
        if (File::exists($coursesCsv)) {
            $handle = fopen($coursesCsv, 'r');
            fgetcsv($handle, 0, ',', '"', '\\'); // Skip header

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            $batch = [];
            while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
                $batch[] = [
                    'id'                => (int)$row[0],
                    'program_id'        => !empty($row[1]) ? (int)$row[1] : null,
                    'institution_id'    => (int)$row[2],
                    'category_id'       => (int)$row[3],
                    'title'             => $row[4],
                    'slug'              => $row[5],
                    'short_description' => $row[6],
                    'description'       => $row[7] ?? null,
                    'price'             => (int)($row[8] ?? 0),
                    'duration_weeks'    => (int)($row[9] ?? 4),
                    'difficulty'        => $row[10] ?: 'beginner',
                    'thumbnail_url'     => $row[11] ?? null,
                    'preview_video_url' => $row[12] ?? null,
                    'language'          => $row[13] ?: 'en',
                    'is_published'      => (int)($row[14] ?? 1),
                    'order_index'       => (int)($row[15] ?? 0),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];

                if (count($batch) === 100) {
                    DB::table('courses')->upsert($batch, ['slug'], [
                        'title', 'category_id', 'institution_id', 'program_id',
                        'short_description', 'description', 'price', 'duration_weeks',
                        'difficulty', 'thumbnail_url', 'preview_video_url',
                        'language', 'is_published', 'order_index', 'updated_at'
                    ]);
                    $batch = [];
                }
            }

            if (!empty($batch)) {
                DB::table('courses')->upsert($batch, ['slug'], [
                    'title', 'category_id', 'institution_id', 'program_id',
                    'short_description', 'description', 'price', 'duration_weeks',
                    'difficulty', 'thumbnail_url', 'preview_video_url',
                    'language', 'is_published', 'order_index', 'updated_at'
                ]);
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            fclose($handle);
            $this->command->info('Data Courses berhasil diimport: ' . DB::table('courses')->count() . ' rows.');
        } else {
            $this->command->error('File courses_raw.csv tidak ditemukan di database/data/csv/');
        }

        // 3. Import Relasi Instruktur dari CSV (Pivot Table)
        $instructorsCsv = database_path('data/csv/course_instructors.csv');
        if (File::exists($instructorsCsv)) {
            $handle = fopen($instructorsCsv, 'r');
            fgetcsv($handle, 0, ',', '"', '\\'); // Skip header

            while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
                DB::table('course_instructors')->insertOrIgnore([
                    'id'         => (int)$row[0],
                    'course_id'  => (int)$row[1],
                    'user_id'    => (int)$row[2],
                    'role'       => $row[3] ?: 'lead',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            fclose($handle);
            $this->command->info('Data Course Instructors berhasil diimport.');
        }

        // 4. Reset Auto Increment agar ID baru tidak berantakan
        $finalMaxCourseId = DB::table('courses')->max('id') + 1;
        DB::statement("ALTER TABLE courses AUTO_INCREMENT = $finalMaxCourseId;");

        $finalMaxPivotId = DB::table('course_instructors')->max('id') + 1;
        DB::statement("ALTER TABLE course_instructors AUTO_INCREMENT = $finalMaxPivotId;");
    }
}