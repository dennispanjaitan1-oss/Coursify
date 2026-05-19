<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
 
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,      // 1. Kategori
            InstitutionSeeder::class,   // 2. Institusi
            ProgramSeeder::class,       // 3. Program
            UserSeeder::class,          // 4. User (admin + instructor CSV + demo users + 200 students)
            CourseSeeder::class,        // 5. Kursus + Pivot course_instructors (dari CSV)
            CourseContentSeeder::class, // 6. Section & Lesson dummy
            EnrollmentSeeder::class,    // 7. Enrollments, Payments, Progress dummy
            ReviewSeeder::class,        // 8. Reviews dummy
        ]);
 
        $this->command->info('✅ Seeding selesai!');
        $this->command->info('');
        $this->command->info('🔑 Akun login:');
        $this->command->info('   Admin      → admin@coursify.com / password');
        $this->command->info('   Instructor → instructor@coursify.com / password');
        $this->command->info('   Student    → student@coursify.com / password');
        $this->command->info('');
        $this->command->info('📊 Data summary:');
        $this->command->info('   Categories  → ' . \DB::table('categories')->count() . ' records');
        $this->command->info('   Institutions→ ' . \DB::table('institutions')->count() . ' records');
        $this->command->info('   Programs    → ' . \DB::table('programs')->count() . ' records');
        $this->command->info('   Users       → ' . \DB::table('users')->count() . ' records');
        $this->command->info('   Courses     → ' . \DB::table('courses')->count() . ' records');
        $this->command->info('   Enrollments → ' . \DB::table('enrollments')->count() . ' records');
        $this->command->info('   Payments    → ' . \DB::table('payments')->count() . ' records');
        $this->command->info('   Reviews     → ' . \DB::table('reviews')->count() . ' records');
    }
}
