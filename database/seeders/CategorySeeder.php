<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = database_path('data/csv/categories_raw.csv');

        if (File::exists($csvFile)) {
            $handle = fopen($csvFile, 'r');
            fgetcsv($handle, 0, ',', '"', '\\'); // Skip header

            while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
                // insertOrIgnore: skip jika slug duplikat, tidak throw exception
                DB::table('categories')->insertOrIgnore([
                    'id'         => $row[0],
                    'name'       => $row[1],
                    'slug'       => Str::slug($row[2]),
                    'parent_id'  => !empty($row[3]) ? $row[3] : null,
                    'icon'       => !empty($row[4]) ? $row[4] : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            fclose($handle);

            // Reset Auto Increment
            $maxId = DB::table('categories')->max('id') + 1;
            DB::statement("ALTER TABLE categories AUTO_INCREMENT = $maxId;");
        }
    }
}