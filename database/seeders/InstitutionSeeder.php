<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class InstitutionSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Institution::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = database_path('data/csv/institutions_raw.csv');

        if (File::exists($csvFile)) {
            $handle = fopen($csvFile, 'r');
            fgetcsv($handle, 0, ',', '"', '\\');

            while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
                DB::table('institutions')->insertOrIgnore([
                    'id'          => $row[0],
                    'name'        => $row[1],
                    'slug' => Str::slug($row[1]) . '-' . $row[0],
                    'logo_url'    => !empty($row[3]) ? $row[3] : null,
                    'website_url' => !empty($row[4]) ? $row[4] : null,
                    'description' => !empty($row[5]) ? $row[5] : null,
                    'is_verified' => (bool)($row[6] ?? false),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
            fclose($handle);

            $maxId = DB::table('institutions')->max('id') + 1;
            DB::statement("ALTER TABLE institutions AUTO_INCREMENT = $maxId;");

        } else {
            DB::table('institutions')->insert([
                'name'        => 'Coursify Institution',
                'slug'        => 'coursify-institution',
                'is_verified' => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}