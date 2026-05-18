<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Add performance indexes on frequently queried columns
     */
    public function up(): void
    {
        // ──────────────────────────────────────── COURSES INDEXES ───────────────────────────────────────
        Schema::table('courses', function (Blueprint $table) {
            $table->index('is_published', 'idx_courses_is_published');
            $table->index('category_id', 'idx_courses_category_id');
            $table->index('institution_id', 'idx_courses_institution_id');
            $table->index('program_id', 'idx_courses_program_id');
            $table->index('deleted_at', 'idx_courses_deleted_at');
            // Composite index for common query: published courses in category
            $table->index(['is_published', 'category_id', 'deleted_at'], 'idx_courses_published_category');
        });

        // ──────────────────────────────────────── ENROLLMENTS INDEXES ───────────────────────────────────────
        Schema::table('enrollments', function (Blueprint $table) {
            $table->index('user_id', 'idx_enrollments_user_id');
            $table->index('course_id', 'idx_enrollments_course_id');
            $table->index('payment_id', 'idx_enrollments_payment_id');
            $table->index('status', 'idx_enrollments_status');
            // Composite index for: "get user's active enrollments"
            $table->index(['user_id', 'status'], 'idx_enrollments_user_status');
            // Composite index for: "get course enrollments"
            $table->index(['course_id', 'status'], 'idx_enrollments_course_status');
        });

        // ──────────────────────────────────────── REVIEWS INDEXES ───────────────────────────────────────
        Schema::table('reviews', function (Blueprint $table) {
            $table->index('user_id', 'idx_reviews_user_id');
            $table->index('course_id', 'idx_reviews_course_id');
            $table->index('is_visible', 'idx_reviews_is_visible');
            // Composite index for: "get visible reviews for a course"
            $table->index(['course_id', 'is_visible'], 'idx_reviews_course_visible');
        });

        // ──────────────────────────────────────── LESSON_PROGRESS INDEXES ───────────────────────────────────────
        Schema::table('lesson_progress', function (Blueprint $table) {
            $table->index('user_id', 'idx_lesson_progress_user_id');
            $table->index('lesson_id', 'idx_lesson_progress_lesson_id');
            $table->index('is_completed', 'idx_lesson_progress_is_completed');
            // Composite index for: "get user's progress in a lesson"
            $table->index(['user_id', 'lesson_id'], 'idx_lesson_progress_user_lesson');
            // Composite index for: "get completion stats"
            $table->index(['lesson_id', 'is_completed'], 'idx_lesson_progress_lesson_completed');
        });

        // ──────────────────────────────────────── PAYMENTS INDEXES ───────────────────────────────────────
        Schema::table('payments', function (Blueprint $table) {
            $table->index('user_id', 'idx_payments_user_id');
            $table->index('status', 'idx_payments_status');
            $table->index('transaction_id', 'idx_payments_transaction_id');
            // Composite index for: "get user's paid payments"
            $table->index(['user_id', 'status'], 'idx_payments_user_status');
        });

        // ──────────────────────────────────────── PAYMENT_ITEMS INDEXES ───────────────────────────────────────
        Schema::table('payment_items', function (Blueprint $table) {
            $table->index('payment_id', 'idx_payment_items_payment_id');
            $table->index('course_id', 'idx_payment_items_course_id');
            $table->index('program_id', 'idx_payment_items_program_id');
        });

        // ──────────────────────────────────────── CERTIFICATES INDEXES ───────────────────────────────────────
        Schema::table('certificates', function (Blueprint $table) {
            $table->index('user_id', 'idx_certificates_user_id');
            $table->index('course_id', 'idx_certificates_course_id');
            $table->index('certificate_number', 'idx_certificates_certificate_number');
        });

        // ──────────────────────────────────────── WISHLISTS INDEXES ───────────────────────────────────────
        Schema::table('wishlists', function (Blueprint $table) {
            $table->index('user_id', 'idx_wishlists_user_id');
            $table->index('course_id', 'idx_wishlists_course_id');
            // Composite index for: "check if course is in user's wishlist"
            $table->index(['user_id', 'course_id'], 'idx_wishlists_user_course');
        });

        // ──────────────────────────────────────── SECTIONS INDEXES ───────────────────────────────────────
        Schema::table('sections', function (Blueprint $table) {
            $table->index('course_id', 'idx_sections_course_id');
        });

        // ──────────────────────────────────────── LESSONS INDEXES ───────────────────────────────────────
        Schema::table('lessons', function (Blueprint $table) {
            $table->index('section_id', 'idx_lessons_section_id');
        });

        // ──────────────────────────────────────── QUIZZES INDEXES ───────────────────────────────────────
        Schema::table('quizzes', function (Blueprint $table) {
            $table->index('lesson_id', 'idx_quizzes_lesson_id');
        });

        // ──────────────────────────────────────── QUIZ_OPTIONS INDEXES ───────────────────────────────────────
        Schema::table('quiz_options', function (Blueprint $table) {
            $table->index('quiz_id', 'idx_quiz_options_quiz_id');
        });

        // ──────────────────────────────────────── CATEGORIES INDEXES ───────────────────────────────────────
        Schema::table('categories', function (Blueprint $table) {
            $table->index('parent_id', 'idx_categories_parent_id');
        });

        // ──────────────────────────────────────── COURSE_INSTRUCTORS INDEXES ───────────────────────────────────────
        Schema::table('course_instructors', function (Blueprint $table) {
            $table->index('user_id', 'idx_course_instructors_user_id');
            $table->index('course_id', 'idx_course_instructors_course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropIndex('idx_courses_is_published');
            $table->dropIndex('idx_courses_category_id');
            $table->dropIndex('idx_courses_institution_id');
            $table->dropIndex('idx_courses_program_id');
            $table->dropIndex('idx_courses_deleted_at');
            $table->dropIndex('idx_courses_published_category');
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropIndex('idx_enrollments_user_id');
            $table->dropIndex('idx_enrollments_course_id');
            $table->dropIndex('idx_enrollments_payment_id');
            $table->dropIndex('idx_enrollments_status');
            $table->dropIndex('idx_enrollments_user_status');
            $table->dropIndex('idx_enrollments_course_status');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex('idx_reviews_user_id');
            $table->dropIndex('idx_reviews_course_id');
            $table->dropIndex('idx_reviews_is_visible');
            $table->dropIndex('idx_reviews_course_visible');
        });

        Schema::table('lesson_progress', function (Blueprint $table) {
            $table->dropIndex('idx_lesson_progress_user_id');
            $table->dropIndex('idx_lesson_progress_lesson_id');
            $table->dropIndex('idx_lesson_progress_is_completed');
            $table->dropIndex('idx_lesson_progress_user_lesson');
            $table->dropIndex('idx_lesson_progress_lesson_completed');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex('idx_payments_user_id');
            $table->dropIndex('idx_payments_status');
            $table->dropIndex('idx_payments_transaction_id');
            $table->dropIndex('idx_payments_user_status');
        });

        Schema::table('payment_items', function (Blueprint $table) {
            $table->dropIndex('idx_payment_items_payment_id');
            $table->dropIndex('idx_payment_items_course_id');
            $table->dropIndex('idx_payment_items_program_id');
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->dropIndex('idx_certificates_user_id');
            $table->dropIndex('idx_certificates_course_id');
            $table->dropIndex('idx_certificates_certificate_number');
        });

        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropIndex('idx_wishlists_user_id');
            $table->dropIndex('idx_wishlists_course_id');
            $table->dropIndex('idx_wishlists_user_course');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropIndex('idx_sections_course_id');
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->dropIndex('idx_lessons_section_id');
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropIndex('idx_quizzes_lesson_id');
        });

        Schema::table('quiz_options', function (Blueprint $table) {
            $table->dropIndex('idx_quiz_options_quiz_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_parent_id');
        });

        Schema::table('course_instructors', function (Blueprint $table) {
            $table->dropIndex('idx_course_instructors_user_id');
            $table->dropIndex('idx_course_instructors_course_id');
        });
    }
};
