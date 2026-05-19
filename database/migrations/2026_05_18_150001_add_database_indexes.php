<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // COURSES
        Schema::table('courses', function (Blueprint $table) {
            if (!$this->indexExists('courses', 'idx_courses_is_published'))
                $table->index('is_published', 'idx_courses_is_published');
            if (!$this->indexExists('courses', 'idx_courses_category_id'))
                $table->index('category_id', 'idx_courses_category_id');
            if (!$this->indexExists('courses', 'idx_courses_institution_id'))
                $table->index('institution_id', 'idx_courses_institution_id');
            if (!$this->indexExists('courses', 'idx_courses_published_category'))
                $table->index(['is_published', 'category_id', 'deleted_at'], 'idx_courses_published_category');
        });

        // ENROLLMENTS
        Schema::table('enrollments', function (Blueprint $table) {
            if (!$this->indexExists('enrollments', 'idx_enrollments_user_id'))
                $table->index('user_id', 'idx_enrollments_user_id');
            if (!$this->indexExists('enrollments', 'idx_enrollments_course_id'))
                $table->index('course_id', 'idx_enrollments_course_id');
            if (!$this->indexExists('enrollments', 'idx_enrollments_status'))
                $table->index('status', 'idx_enrollments_status');
            if (!$this->indexExists('enrollments', 'idx_enrollments_user_status'))
                $table->index(['user_id', 'status'], 'idx_enrollments_user_status');
            if (!$this->indexExists('enrollments', 'idx_enrollments_course_status'))
                $table->index(['course_id', 'status'], 'idx_enrollments_course_status');
        });

        // REVIEWS
        Schema::table('reviews', function (Blueprint $table) {
            if (!$this->indexExists('reviews', 'idx_reviews_course_id'))
                $table->index('course_id', 'idx_reviews_course_id');
            if (!$this->indexExists('reviews', 'idx_reviews_is_visible'))
                $table->index('is_visible', 'idx_reviews_is_visible');
            if (!$this->indexExists('reviews', 'idx_reviews_course_visible'))
                $table->index(['course_id', 'is_visible'], 'idx_reviews_course_visible');
        });

        // LESSON_PROGRESS
        Schema::table('lesson_progress', function (Blueprint $table) {
            if (!$this->indexExists('lesson_progress', 'idx_lp_user_lesson'))
                $table->index(['user_id', 'lesson_id'], 'idx_lp_user_lesson');
            if (!$this->indexExists('lesson_progress', 'idx_lp_is_completed'))
                $table->index('is_completed', 'idx_lp_is_completed');
        });

        // PAYMENTS
        Schema::table('payments', function (Blueprint $table) {
            if (!$this->indexExists('payments', 'idx_payments_user_id'))
                $table->index('user_id', 'idx_payments_user_id');
            if (!$this->indexExists('payments', 'idx_payments_status'))
                $table->index('status', 'idx_payments_status');
            if (!$this->indexExists('payments', 'idx_payments_user_status'))
                $table->index(['user_id', 'status'], 'idx_payments_user_status');
        });

        // WISHLISTS
        Schema::table('wishlists', function (Blueprint $table) {
            if (!$this->indexExists('wishlists', 'idx_wishlists_user_course'))
                $table->index(['user_id', 'course_id'], 'idx_wishlists_user_course');
        });

        // CERTIFICATES
        Schema::table('certificates', function (Blueprint $table) {
            if (!$this->indexExists('certificates', 'idx_certificates_user_id'))
                $table->index('user_id', 'idx_certificates_user_id');
            if (!$this->indexExists('certificates', 'idx_certificates_cert_number'))
                $table->index('certificate_number', 'idx_certificates_cert_number');
        });

        // SECTIONS & LESSONS
        Schema::table('sections', function (Blueprint $table) {
            if (!$this->indexExists('sections', 'idx_sections_course_id'))
                $table->index('course_id', 'idx_sections_course_id');
        });
        Schema::table('lessons', function (Blueprint $table) {
            if (!$this->indexExists('lessons', 'idx_lessons_section_id'))
                $table->index('section_id', 'idx_lessons_section_id');
        });

        // COURSE_INSTRUCTORS
        Schema::table('course_instructors', function (Blueprint $table) {
            if (!$this->indexExists('course_instructors', 'idx_ci_user_id'))
                $table->index('user_id', 'idx_ci_user_id');
            if (!$this->indexExists('course_instructors', 'idx_ci_course_id'))
                $table->index('course_id', 'idx_ci_course_id');
        });
    }

    public function down(): void
    {
        $drops = [
            'courses'           => ['idx_courses_is_published','idx_courses_category_id','idx_courses_institution_id','idx_courses_published_category'],
            'enrollments'       => ['idx_enrollments_user_id','idx_enrollments_course_id','idx_enrollments_status','idx_enrollments_user_status','idx_enrollments_course_status'],
            'reviews'           => ['idx_reviews_course_id','idx_reviews_is_visible','idx_reviews_course_visible'],
            'lesson_progress'   => ['idx_lp_user_lesson','idx_lp_is_completed'],
            'payments'          => ['idx_payments_user_id','idx_payments_status','idx_payments_user_status'],
            'wishlists'         => ['idx_wishlists_user_course'],
            'certificates'      => ['idx_certificates_user_id','idx_certificates_cert_number'],
            'sections'          => ['idx_sections_course_id'],
            'lessons'           => ['idx_lessons_section_id'],
            'course_instructors'=> ['idx_ci_user_id','idx_ci_course_id'],
        ];

        foreach ($drops as $table => $indexes) {
            Schema::table($table, function (\Illuminate\Database\Schema\Blueprint $t) use ($indexes) {
                foreach ($indexes as $idx) {
                    try { $t->dropIndex($idx); } catch (\Exception $e) {}
                }
            });
        }
    }

    private function indexExists(string $table, string $indexName): bool
    {
        $indexes = \Illuminate\Support\Facades\DB::select(
            "SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$indexName]
        );
        return count($indexes) > 0;
    }
};
