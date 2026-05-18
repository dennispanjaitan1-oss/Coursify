<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Add data integrity CHECK constraints to ensure data consistency
     */
    public function up(): void
    {
        // ──────────────────────────────────────── REVIEWS CONSTRAINTS ───────────────────────────────────────
        // Ensure rating is between 1-5
        DB::statement('ALTER TABLE reviews ADD CONSTRAINT check_reviews_rating CHECK (rating >= 1 AND rating <= 5)');

        // ──────────────────────────────────────── PAYMENTS CONSTRAINTS ───────────────────────────────────────
        // Ensure amount is non-negative
        DB::statement('ALTER TABLE payments ADD CONSTRAINT check_payments_amount CHECK (amount >= 0)');

        // ──────────────────────────────────────── COURSES CONSTRAINTS ───────────────────────────────────────
        // Ensure price is non-negative
        DB::statement('ALTER TABLE courses ADD CONSTRAINT check_courses_price CHECK (price >= 0)');

        // Ensure duration_weeks is positive
        DB::statement('ALTER TABLE courses ADD CONSTRAINT check_courses_duration_weeks CHECK (duration_weeks > 0)');

        // Ensure avg_rating is between 0-5
        DB::statement('ALTER TABLE courses ADD CONSTRAINT check_courses_avg_rating CHECK (avg_rating >= 0 AND avg_rating <= 5)');

        // Ensure total_reviews is non-negative
        DB::statement('ALTER TABLE courses ADD CONSTRAINT check_courses_total_reviews CHECK (total_reviews >= 0)');

        // Ensure total_students is non-negative
        DB::statement('ALTER TABLE courses ADD CONSTRAINT check_courses_total_students CHECK (total_students >= 0)');

        // ──────────────────────────────────────── ENROLLMENTS CONSTRAINTS ───────────────────────────────────────
        // Ensure progress_percent is between 0-100
        DB::statement('ALTER TABLE enrollments ADD CONSTRAINT check_enrollments_progress_percent CHECK (progress_percent >= 0 AND progress_percent <= 100)');

        // ──────────────────────────────────────── PAYMENT_ITEMS CONSTRAINTS ───────────────────────────────────────
        // Ensure price is non-negative
        DB::statement('ALTER TABLE payment_items ADD CONSTRAINT check_payment_items_price CHECK (price >= 0)');

        // Removed check_payment_items_has_item because MySQL prohibits CHECK constraints 
        // on columns with ON DELETE SET NULL foreign keys.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE reviews DROP CONSTRAINT check_reviews_rating');
        DB::statement('ALTER TABLE payments DROP CONSTRAINT check_payments_amount');
        DB::statement('ALTER TABLE courses DROP CONSTRAINT check_courses_price');
        DB::statement('ALTER TABLE courses DROP CONSTRAINT check_courses_duration_weeks');
        DB::statement('ALTER TABLE courses DROP CONSTRAINT check_courses_avg_rating');
        DB::statement('ALTER TABLE courses DROP CONSTRAINT check_courses_total_reviews');
        DB::statement('ALTER TABLE courses DROP CONSTRAINT check_courses_total_students');
        DB::statement('ALTER TABLE enrollments DROP CONSTRAINT check_enrollments_progress_percent');
        DB::statement('ALTER TABLE payment_items DROP CONSTRAINT check_payment_items_price');
    }
};
