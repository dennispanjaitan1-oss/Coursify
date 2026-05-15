<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Program::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = database_path('data/csv/programs_raw.csv');

        if (File::exists($csvFile)) {
            $handle = fopen($csvFile, 'r');
            fgetcsv($handle, 0, ',', '"', '\\'); // ✅ tambah parameter escape

            while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) { // ✅ sama
                DB::table('programs')->insertOrIgnore([ // ✅ ganti insert → insertOrIgnore
                    'id'             => $row[0],
                    'institution_id' => $row[1],
                    'category_id'    => $row[2],
                    'title'          => $row[3],
                    'slug'           => $row[4],
                    'type'           => $row[5],
                    'description'    => !empty($row[6]) ? $row[6] : null,
                    'price'          => (float)($row[7] ?? 0),
                    'thumbnail_url'  => !empty($row[8]) ? $row[8] : null,
                    'is_published'   => (bool)($row[9] ?? false),
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
            fclose($handle);

            $maxId = DB::table('programs')->max('id') + 1;
            DB::statement("ALTER TABLE programs AUTO_INCREMENT = $maxId;");
        }
    }
}