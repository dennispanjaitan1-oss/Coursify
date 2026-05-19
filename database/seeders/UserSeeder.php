<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $maxId = 0; // default jika CSV tidak ada
        $password = Hash::make('password');

        // Data dari file CSV
        $csvFile = database_path('data/csv/users_instructors.csv');
        if (File::exists($csvFile)) {
            $handle = fopen($csvFile, 'r');
            fgetcsv($handle, 0, ',', '"', '\\');

            while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
                DB::table('users')->insert([
                    'id'                => $row[0],
                    'name'              => $row[1],
                    'email'             => $row[2],
                    'password'          => $password,
                    'role'              => 'instructor',
                    'email_verified_at' => now(),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }
            fclose($handle);
            $maxId = DB::table('users')->max('id');
        }

        // 2. Akun Demo
        User::create([
            'id'                => $maxId + 1,
            'name'              => 'Admin Coursify',
            'email'             => 'admin@coursify.com',
            'password'          => $password,
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'id'                => $maxId + 2,
            'name'              => 'Instructor Demo',
            'email'             => 'instructor@coursify.com',
            'password'          => $password,
            'role'              => 'instructor',
            'email_verified_at' => now(),
        ]);

        User::create([
            'id'                => $maxId + 3,
            'name'              => 'Student Demo',
            'email'             => 'student@coursify.com',
            'password'          => $password,
            'role'              => 'student',
            'email_verified_at' => now(),
        ]);

        // 3. Generate 200 Students
        $faker = \Faker\Factory::create('id_ID');
        $students = [];
        $currentId = $maxId + 4;
        
        for ($i = 0; $i < 200; $i++) {
            $students[] = [
                'id'                => $currentId++,
                'name'              => $faker->name,
                'email'             => $faker->unique()->safeEmail,
                'password'          => $password,
                'role'              => 'student',
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
        }
        
        foreach (array_chunk($students, 100) as $chunk) {
            DB::table('users')->insert($chunk);
        }

        $finalMaxId = DB::table('users')->max('id') + 1;
        DB::statement("ALTER TABLE users AUTO_INCREMENT = $finalMaxId;");

        $this->command->info('✅ Users seeded: ' . DB::table('users')->count() . ' records (instructors + admins + 200 students)');
    }
}