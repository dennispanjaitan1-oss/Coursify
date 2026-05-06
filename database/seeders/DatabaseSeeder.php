<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
 
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,      // 1. Kategori dulu
            InstitutionSeeder::class,   // 2. Institusi
            UserSeeder::class,          // 3. User (admin, instructor, student)
            CourseSeeder::class,        // 4. Kursus + Section + Lesson
            EnrollmentSeeder::class,    // 5. Enrollment + Payment + LessonProgress
            ReviewSeeder::class,        // 6. Review + Certificate
        ]);
 
        $this->command->info('✅ Seeding selesai!');
        $this->command->info('');
        $this->command->info('🔑 Akun login:');
        $this->command->info('   Admin      → admin@coursify.com / password');
        $this->command->info('   Instructor → instructor@coursify.com / password');
        $this->command->info('   Student    → student@coursify.com / password');
    }
}
