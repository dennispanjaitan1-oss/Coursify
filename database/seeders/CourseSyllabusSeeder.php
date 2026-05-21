<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class CourseSyllabusSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('course_syllabus')->truncate();
        Schema::enableForeignKeyConstraints();

        $csv = database_path('data/csv/subject_courses.csv');

        if (!File::exists($csv)) {
            $this->command->error('File subject_courses.csv tidak ditemukan di database/data/csv/');
            return;
        }

        // Ambil semua course_id yang benar-benar ada di DB
        $validCourseIds = DB::table('courses')->pluck('id')->flip()->all();

        $handle = fopen($csv, 'r');
        fgetcsv($handle, 0, ',', '"', '\\'); // Skip header

        $batch = [];
        $skipped = 0;
        $now = now();

        while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
            $courseId = (int) $row[0];

            // Lewati jika course_id tidak ada di tabel courses
            if (!isset($validCourseIds[$courseId])) {
                $skipped++;
                continue;
            }

            $batch[] = [
                'course_id'   => $courseId,
                'item'        => trim($row[1]),
                'order_index' => (int) $row[2],
                'created_at'  => $now,
                'updated_at'  => $now,
            ];

            if (count($batch) === 500) {
                DB::table('course_syllabus')->insert($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            DB::table('course_syllabus')->insert($batch);
        }

        fclose($handle);

        $count = DB::table('course_syllabus')->count();
        $this->command->info("Silabus berhasil diimport: {$count} rows. (dilewati: {$skipped} rows karena course tidak ditemukan)");
    }
}