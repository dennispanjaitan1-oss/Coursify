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
            ProgramSeeder::class,       // 3. Program
            UserSeeder::class,          // 4. User (admin + instructor CSV + 200 students)
            CourseSeeder::class,        // 5. Kursus + Section + Lesson (dari CSV)
            CourseContentSeeder::class, // 6. Section & Lesson content
            EnrollmentSeeder::class,    // 7. Enrollment + Payment + LessonProgress (~1000 enrollments)
            ReviewSeeder::class,        // 8. Reviews (hingga 500 reviews)
            PaymentSeeder::class,       // 9. Payment edge cases (failed/pending/refunded)
        ]);
 
        $this->command->info('');
        $this->command->info('✅ Seeding selesai!');
        $this->command->info('');
        $this->command->info('🔑 Akun login:');
        $this->command->info('   Admin      → admin@coursify.com / password');
        $this->command->info('   Instructor → instructor@coursify.com / password');
        $this->command->info('   Student    → student@coursify.com / password');
        $this->command->info('');
        $this->command->info('📊 Data summary:');
        $this->command->info('   Users       → ' . \DB::table('users')->count() . ' records');
        $this->command->info('   Courses     → ' . \DB::table('courses')->count() . ' records');
        $this->command->info('   Enrollments → ' . \DB::table('enrollments')->count() . ' records');
        $this->command->info('   Reviews     → ' . \DB::table('reviews')->count() . ' records');
        $this->command->info('   Payments    → ' . \DB::table('payments')->count() . ' records');
    }
}
