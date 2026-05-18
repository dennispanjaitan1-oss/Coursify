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

        // 1. Data instruktur dari file CSV
        $csvFile = database_path('data/csv/users_instructors.csv');
        if (File::exists($csvFile)) {
            $handle = fopen($csvFile, 'r');
            fgetcsv($handle, 0, ',', '"', '\\');

            while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
                DB::table('users')->insert([
                    'id'                => $row[0],
                    'name'              => $row[1],
                    'email'             => $row[2],
                    'password'          => Hash::make('password'),
                    'role'              => 'instructor',
                    'email_verified_at' => now(),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }
            fclose($handle);
            $maxId = DB::table('users')->max('id');
        }

        // 2. Akun Demo (admin, instructor, student)
        User::create([
            'id'                => $maxId + 1,
            'name'              => 'Admin Coursify',
            'email'             => 'admin@coursify.com',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'id'                => $maxId + 2,
            'name'              => 'Instructor Demo',
            'email'             => 'instructor@coursify.com',
            'password'          => Hash::make('password'),
            'role'              => 'instructor',
            'email_verified_at' => now(),
        ]);

        User::create([
            'id'                => $maxId + 3,
            'name'              => 'Student Demo',
            'email'             => 'student@coursify.com',
            'password'          => Hash::make('password'),
            'role'              => 'student',
            'email_verified_at' => now(),
        ]);

        // 3. Generate 200 student acak dengan Faker
        $faker      = \Faker\Factory::create('id_ID');
        $usedEmails = DB::table('users')->pluck('email')->toArray();
        $batch      = [];
        $currentId  = DB::table('users')->max('id') + 1;

        $headlines = [
            'Mahasiswa Teknik Informatika', 'Software Developer Junior', 'Fresh Graduate',
            'UI/UX Enthusiast', 'Data Science Learner', 'Backend Developer',
            'Frontend Developer', 'Mobile App Developer', 'Digital Marketing Student',
            'Business Analyst Trainee', 'Graphic Designer', 'Cybersecurity Enthusiast',
            'Product Manager Trainee', 'DevOps Learner', 'Cloud Computing Enthusiast',
        ];

        $bios = [
            'Sedang belajar pemrograman untuk membangun karir di bidang teknologi.',
            'Passionate tentang desain dan pengembangan produk digital.',
            'Ingin meningkatkan skill agar bisa bekerja di perusahaan teknologi terkemuka.',
            'Hobi coding dan suka mengeksplorasi teknologi baru.',
            'Belajar mandiri untuk menjadi full-stack developer.',
            'Tertarik dengan AI, machine learning, dan data science.',
            'Mengembangkan skill untuk bisa berkontribusi di startup teknologi.',
            'Lifelong learner yang selalu ingin terus berkembang.',
        ];

        for ($i = 0; $i < 200; $i++) {
            $email = null;
            $attempt = 0;
            do {
                $email = strtolower($faker->firstName() . '.' . $faker->lastName() . $faker->numberBetween(1, 9999) . '@' . $faker->freeEmailDomain());
                $attempt++;
            } while (in_array($email, $usedEmails) && $attempt < 10);

            $usedEmails[] = $email;

            $createdAt = now()->subDays(rand(1, 365));

            $batch[] = [
                'id'                => $currentId++,
                'name'              => $faker->name(),
                'email'             => $email,
                'password'          => Hash::make('password'),
                'role'              => 'student',
                'bio'               => $faker->randomElement($bios),
                'headline'          => $faker->randomElement($headlines),
                'email_verified_at' => $createdAt,
                'created_at'        => $createdAt,
                'updated_at'        => $createdAt->copy()->addDays(rand(0, 30)),
            ];

            if (count($batch) === 50) {
                DB::table('users')->insert($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            DB::table('users')->insert($batch);
        }

        $finalMaxId = DB::table('users')->max('id') + 1;
        DB::statement("ALTER TABLE users AUTO_INCREMENT = $finalMaxId;");

        $this->command->info('✅ Users seeded: ' . DB::table('users')->count() . ' records (200 students + instructors + admins)');
    }
}