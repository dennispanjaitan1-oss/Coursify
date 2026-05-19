<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // VIEW 1: Active Enrollments
        DB::statement("
            CREATE OR REPLACE VIEW v_active_enrollments AS
            SELECT 
                e.id AS enrollment_id,
                e.user_id,
                e.course_id,
                e.type,
                e.status,
                e.progress_percent,
                e.completed_at,
                e.created_at AS enrolled_at,
                u.name,
                u.email,
                c.title AS course_title,
                c.price,
                c.difficulty,
                c.avg_rating
            FROM enrollments e
            JOIN users u ON e.user_id = u.id
            JOIN courses c ON e.course_id = c.id
            WHERE e.status = 'active' AND c.deleted_at IS NULL
        ");

        // VIEW 2: Instructor Revenue
        DB::statement("
            CREATE OR REPLACE VIEW v_instructor_revenue AS
            SELECT 
                ci.user_id AS instructor_id,
                u.name AS instructor_name,
                u.email AS instructor_email,
                c.id AS course_id,
                c.title AS course_title,
                COUNT(DISTINCT e.id) AS total_enrollments,
                COUNT(DISTINCT CASE WHEN e.status = 'completed' THEN e.id END) AS completed_enrollments,
                COALESCE(SUM(CASE WHEN p.status = 'paid' THEN pi.price ELSE 0 END), 0) AS total_revenue,
                COALESCE(c.avg_rating, 0) AS avg_rating,
                c.total_reviews
            FROM course_instructors ci
            JOIN users u ON ci.user_id = u.id
            JOIN courses c ON ci.course_id = c.id
            LEFT JOIN enrollments e ON e.course_id = c.id
            LEFT JOIN payments p ON p.id = e.payment_id
            LEFT JOIN payment_items pi ON pi.payment_id = p.id AND pi.course_id = c.id
            GROUP BY ci.user_id, u.name, u.email, c.id, c.title, c.avg_rating, c.total_reviews
        ");

        // VIEW 3: Student Learning Progress
        DB::statement("
            CREATE OR REPLACE VIEW v_student_learning_progress AS
            SELECT 
                e.user_id,
                u.name,
                e.course_id,
                c.title AS course_title,
                COUNT(DISTINCT l.id) AS total_lessons,
                COUNT(DISTINCT CASE WHEN lp.is_completed = 1 THEN lp.id END) AS completed_lessons,
                e.progress_percent,
                e.status,
                e.type,
                e.created_at AS enrolled_at,
                e.completed_at
            FROM enrollments e
            JOIN users u ON e.user_id = u.id
            JOIN courses c ON e.course_id = c.id
            LEFT JOIN sections s ON s.course_id = c.id
            LEFT JOIN lessons l ON l.section_id = s.id
            LEFT JOIN lesson_progress lp ON lp.lesson_id = l.id AND lp.user_id = e.user_id
            GROUP BY e.id, e.user_id, u.name, e.course_id, c.title, e.progress_percent, e.status, e.type, e.created_at, e.completed_at
        ");

        // VIEW 4: Top Courses By Enrollment
        DB::statement("
            CREATE OR REPLACE VIEW v_top_courses_by_enrollment AS
            SELECT 
                c.id,
                c.title,
                c.slug,
                c.price,
                c.difficulty,
                c.avg_rating,
                c.total_reviews,
                c.total_students,
                COUNT(DISTINCT e.id) AS total_enrollments,
                cat.name AS category_name
            FROM courses c
            LEFT JOIN enrollments e ON e.course_id = c.id
            LEFT JOIN categories cat ON c.category_id = cat.id
            WHERE c.is_published = 1 AND c.deleted_at IS NULL
            GROUP BY c.id, c.title, c.slug, c.price, c.difficulty, c.avg_rating, c.total_reviews, c.total_students, cat.name
            ORDER BY total_enrollments DESC
        ");

        // VIEW 5: Course Completion Stats
        DB::statement("
            CREATE OR REPLACE VIEW v_course_completion_stats AS
            SELECT 
                c.id,
                c.title,
                COUNT(DISTINCT e.id) AS total_enrollments,
                COUNT(DISTINCT CASE WHEN e.status = 'completed' THEN e.id END) AS completed_enrollments,
                ROUND(
                    (COUNT(DISTINCT CASE WHEN e.status = 'completed' THEN e.id END) / 
                    NULLIF(COUNT(DISTINCT e.id), 0)) * 100, 2
                ) AS completion_rate_percent,
                ROUND(AVG(e.progress_percent), 2) AS avg_progress_percent
            FROM courses c
            LEFT JOIN enrollments e ON e.course_id = c.id
            WHERE c.deleted_at IS NULL
            GROUP BY c.id, c.title
        ");

        // VIEW 6: Latest User Reviews
        DB::statement("
            CREATE OR REPLACE VIEW v_latest_user_reviews AS
            SELECT 
                r.id,
                r.user_id,
                u.name AS reviewer_name,
                r.course_id,
                c.title AS course_title,
                r.rating,
                r.comment,
                r.is_visible,
                r.created_at
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            JOIN courses c ON r.course_id = c.id
            WHERE r.is_visible = 1 AND c.deleted_at IS NULL
            ORDER BY r.created_at DESC
        ");
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_latest_user_reviews');
        DB::statement('DROP VIEW IF EXISTS v_course_completion_stats');
        DB::statement('DROP VIEW IF EXISTS v_top_courses_by_enrollment');
        DB::statement('DROP VIEW IF EXISTS v_student_learning_progress');
        DB::statement('DROP VIEW IF EXISTS v_instructor_revenue');
        DB::statement('DROP VIEW IF EXISTS v_active_enrollments');
    }
};
