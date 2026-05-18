<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Create database views and complete stored procedures for analytics and business logic
     */
    public function up(): void
    {
        // ═══════════════════════════════════════════════════════════════════════════════════
        // DATABASE VIEWS
        // ═══════════════════════════════════════════════════════════════════════════════════

        // ──────────────────────────────────────── ACTIVE ENROLLMENTS VIEW ───────────────────────────────────────
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
                u.id,
                u.name,
                u.email,
                u.role,
                c.id AS course_id_dup,
                c.title AS course_title,
                c.slug,
                c.price,
                c.duration_weeks,
                c.difficulty,
                c.thumbnail_url,
                c.avg_rating,
                c.total_reviews,
                c.total_students
            FROM enrollments e
            JOIN users u ON e.user_id = u.id
            JOIN courses c ON e.course_id = c.id
            WHERE e.status = 'active' AND c.deleted_at IS NULL
        ");

        // ──────────────────────────────────────── INSTRUCTOR REVENUE VIEW ───────────────────────────────────────
        DB::statement("
            CREATE OR REPLACE VIEW v_instructor_revenue AS
            SELECT 
                ci.user_id AS instructor_id,
                u.name AS instructor_name,
                u.email AS instructor_email,
                c.id AS course_id,
                c.title AS course_title,
                c.slug,
                COUNT(DISTINCT e.id) AS total_enrollments,
                COUNT(DISTINCT CASE WHEN e.status = 'completed' THEN e.id END) AS completed_enrollments,
                COUNT(DISTINCT CASE WHEN e.status = 'active' THEN e.id END) AS active_enrollments,
                COALESCE(SUM(CASE WHEN p.status = 'paid' THEN pi.price ELSE 0 END), 0) AS total_revenue,
                COALESCE(AVG(r.rating), 0) AS avg_rating,
                COUNT(DISTINCT r.id) AS total_reviews,
                c.created_at
            FROM course_instructors ci
            JOIN users u ON ci.user_id = u.id
            JOIN courses c ON ci.course_id = c.id
            LEFT JOIN enrollments e ON e.course_id = c.id
            LEFT JOIN payments p ON p.id = e.payment_id
            LEFT JOIN payment_items pi ON pi.payment_id = p.id AND pi.course_id = c.id
            LEFT JOIN reviews r ON r.course_id = c.id
            GROUP BY ci.user_id, u.name, u.email, c.id, c.title, c.slug, c.created_at
        ");

        // ──────────────────────────────────────── STUDENT LEARNING PROGRESS VIEW ───────────────────────────────────────
        DB::statement("
            CREATE OR REPLACE VIEW v_student_learning_progress AS
            SELECT 
                e.user_id,
                u.name,
                u.email,
                e.course_id,
                c.title AS course_title,
                c.slug,
                COUNT(DISTINCT l.id) AS total_lessons,
                COUNT(DISTINCT CASE WHEN lp.is_completed = 1 THEN lp.id END) AS completed_lessons,
                ROUND(
                    (COUNT(DISTINCT CASE WHEN lp.is_completed = 1 THEN lp.id END) / 
                    NULLIF(COUNT(DISTINCT l.id), 0)) * 100, 2
                ) AS lesson_completion_percent,
                COUNT(DISTINCT q.id) AS total_quizzes,
                e.progress_percent,
                e.status,
                e.type,
                e.created_at AS enrolled_at,
                e.completed_at,
                COALESCE(MAX(lp.updated_at), e.created_at) AS last_activity_at
            FROM enrollments e
            JOIN users u ON e.user_id = u.id
            JOIN courses c ON e.course_id = c.id
            LEFT JOIN sections s ON s.course_id = c.id
            LEFT JOIN lessons l ON l.section_id = s.id
            LEFT JOIN lesson_progress lp ON lp.lesson_id = l.id AND lp.user_id = e.user_id
            LEFT JOIN quizzes q ON q.lesson_id = l.id
            GROUP BY e.id, e.user_id, u.name, u.email, e.course_id, c.title, c.slug, 
                     e.progress_percent, e.status, e.type, e.created_at, e.completed_at
        ");

        // ──────────────────────────────────────── TOP COURSES BY ENROLLMENT ───────────────────────────────────────
        DB::statement("
            CREATE OR REPLACE VIEW v_top_courses_by_enrollment AS
            SELECT 
                c.id,
                c.title,
                c.slug,
                c.thumbnail_url,
                c.price,
                c.difficulty,
                c.duration_weeks,
                c.avg_rating,
                c.total_reviews,
                c.total_students,
                COUNT(DISTINCT e.id) AS total_enrollments,
                COUNT(DISTINCT CASE WHEN e.status = 'completed' THEN e.id END) AS completed_enrollments,
                ROUND(
                    (COUNT(DISTINCT CASE WHEN e.status = 'completed' THEN e.id END) / 
                    NULLIF(COUNT(DISTINCT e.id), 0)) * 100, 2
                ) AS completion_rate_percent,
                cat.name AS category_name,
                cat.slug AS category_slug
            FROM courses c
            LEFT JOIN enrollments e ON e.course_id = c.id
            LEFT JOIN categories cat ON c.category_id = cat.id
            WHERE c.is_published = 1 AND c.deleted_at IS NULL
            GROUP BY c.id, c.title, c.slug, c.thumbnail_url, c.price, c.difficulty, 
                     c.duration_weeks, c.avg_rating, c.total_reviews, c.total_students,
                     cat.name, cat.slug
            ORDER BY c.total_students DESC
        ");

        // ──────────────────────────────────────── COURSE COMPLETION STATISTICS ───────────────────────────────────────
        DB::statement("
            CREATE OR REPLACE VIEW v_course_completion_stats AS
            SELECT 
                c.id,
                c.title,
                c.slug,
                COUNT(DISTINCT e.id) AS total_enrollments,
                COUNT(DISTINCT CASE WHEN e.status = 'completed' THEN e.id END) AS completed_enrollments,
                COUNT(DISTINCT CASE WHEN e.status = 'active' THEN e.id END) AS active_enrollments,
                ROUND(
                    (COUNT(DISTINCT CASE WHEN e.status = 'completed' THEN e.id END) / 
                    NULLIF(COUNT(DISTINCT e.id), 0)) * 100, 2
                ) AS completion_rate_percent,
                ROUND(AVG(e.progress_percent), 2) AS avg_progress_percent,
                MIN(e.created_at) AS first_enrollment_date,
                MAX(e.completed_at) AS last_completion_date
            FROM courses c
            LEFT JOIN enrollments e ON e.course_id = c.id
            WHERE c.deleted_at IS NULL
            GROUP BY c.id, c.title, c.slug
        ");

        // ──────────────────────────────────────── LATEST USER REVIEWS ───────────────────────────────────────
        DB::statement("
            CREATE OR REPLACE VIEW v_latest_user_reviews AS
            SELECT 
                r.id,
                r.user_id,
                u.name AS reviewer_name,
                r.course_id,
                c.title AS course_title,
                c.slug,
                r.rating,
                r.comment,
                r.is_visible,
                r.created_at,
                r.updated_at
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            JOIN courses c ON r.course_id = c.id
            WHERE r.is_visible = 1 AND c.deleted_at IS NULL
            ORDER BY r.created_at DESC
        ");

        // ═══════════════════════════════════════════════════════════════════════════════════
        // STORED PROCEDURES
        // ═══════════════════════════════════════════════════════════════════════════════════

        // ──────────────────────────────────────── sp_get_course_stats ───────────────────────────────────────
        // Enhanced version with more comprehensive stats
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_get_course_stats;
            CREATE PROCEDURE sp_get_course_stats(
                IN p_course_id BIGINT UNSIGNED
            )
            BEGIN
                SELECT
                    c.id                                            AS course_id,
                    c.title,
                    c.slug,
                    c.price,
                    c.difficulty,
                    c.avg_rating,
                    COUNT(DISTINCT e.id)                            AS total_enrollments,
                    COUNT(DISTINCT CASE WHEN e.status = 'completed' THEN e.id END) 
                                                                    AS completed_enrollments,
                    COUNT(DISTINCT CASE WHEN e.status = 'active' THEN e.id END)
                                                                    AS active_enrollments,
                    ROUND(
                        COUNT(DISTINCT CASE WHEN e.status = 'completed' THEN e.id END)
                        / NULLIF(COUNT(DISTINCT e.id), 0) * 100
                    , 2)                                            AS completion_rate_pct,
                    COUNT(DISTINCT r.id)                            AS total_reviews,
                    COUNT(DISTINCT l.id)                            AS total_lessons,
                    COALESCE(SUM(CASE WHEN p.status = 'paid' THEN pi.price ELSE 0 END), 0)
                                                                    AS total_revenue,
                    ROUND(AVG(e.progress_percent), 2)               AS avg_progress_percent,
                    MIN(e.created_at)                               AS first_enrollment_date,
                    MAX(e.completed_at)                             AS last_completion_date
                FROM courses c
                LEFT JOIN enrollments e ON e.course_id = c.id
                LEFT JOIN reviews r ON r.course_id = c.id
                LEFT JOIN sections s ON s.course_id = c.id
                LEFT JOIN lessons l ON l.section_id = s.id
                LEFT JOIN payments p ON p.id = e.payment_id
                LEFT JOIN payment_items pi ON pi.payment_id = p.id AND pi.course_id = c.id
                WHERE c.id = p_course_id
                GROUP BY c.id, c.title, c.slug, c.price, c.difficulty, c.avg_rating;
            END
        ");

        // ──────────────────────────────────────── sp_get_instructor_revenue ───────────────────────────────────────
        // Get detailed revenue breakdown for instructors
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_get_instructor_revenue;
            CREATE PROCEDURE sp_get_instructor_revenue(
                IN p_instructor_id BIGINT UNSIGNED,
                IN p_from_date DATE,
                IN p_to_date DATE
            )
            BEGIN
                SELECT
                    c.id AS course_id,
                    c.title,
                    c.slug,
                    COUNT(DISTINCT e.id) AS total_enrollments,
                    COUNT(DISTINCT CASE WHEN e.status = 'completed' THEN e.id END) AS completed_enrollments,
                    COALESCE(SUM(CASE WHEN p.status = 'paid' THEN pi.price ELSE 0 END), 0) AS total_revenue,
                    ROUND(AVG(r.rating), 2) AS avg_rating,
                    COUNT(DISTINCT r.id) AS total_reviews
                FROM course_instructors ci
                JOIN courses c ON ci.course_id = c.id
                LEFT JOIN enrollments e ON e.course_id = c.id AND DATE(e.created_at) BETWEEN p_from_date AND p_to_date
                LEFT JOIN payments p ON p.id = e.payment_id
                LEFT JOIN payment_items pi ON pi.payment_id = p.id AND pi.course_id = c.id
                LEFT JOIN reviews r ON r.course_id = c.id
                WHERE ci.user_id = p_instructor_id
                GROUP BY c.id, c.title, c.slug;
            END
        ");

        // ──────────────────────────────────────── sp_get_student_learning_path ───────────────────────────────────────
        // Get detailed learning path for a student in a specific course
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_get_student_learning_path;
            CREATE PROCEDURE sp_get_student_learning_path(
                IN p_user_id BIGINT UNSIGNED,
                IN p_course_id BIGINT UNSIGNED
            )
            BEGIN
                SELECT
                    s.id AS section_id,
                    s.title AS section_title,
                    s.order_index,
                    COUNT(DISTINCT l.id) AS total_lessons_in_section,
                    COUNT(DISTINCT CASE WHEN lp.is_completed = 1 THEN lp.id END) AS completed_lessons,
                    l.id AS lesson_id,
                    l.title AS lesson_title,
                    l.order_index AS lesson_order,
                    l.duration_minutes,
                    COALESCE(lp.is_completed, 0) AS is_lesson_completed,
                    COALESCE(lp.updated_at, NULL) AS lesson_completed_at,
                    0 AS time_spent_minutes,
                    COUNT(DISTINCT q.id) AS total_quizzes_in_lesson
                FROM courses c
                JOIN sections s ON s.course_id = c.id
                LEFT JOIN lessons l ON l.section_id = s.id
                LEFT JOIN lesson_progress lp ON lp.lesson_id = l.id AND lp.user_id = p_user_id
                LEFT JOIN quizzes q ON q.lesson_id = l.id
                WHERE c.id = p_course_id
                GROUP BY s.id, s.title, s.order_index, l.id, l.title, l.order_index, 
                         l.duration_minutes, lp.is_completed, lp.updated_at
                ORDER BY s.order_index, l.order_index;
            END
        ");

        // ──────────────────────────────────────── sp_get_top_courses ───────────────────────────────────────
        // Get trending courses by enrollment and rating
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_get_top_courses;
            CREATE PROCEDURE sp_get_top_courses(
                IN p_limit INT,
                IN p_category_id BIGINT UNSIGNED
            )
            BEGIN
                SELECT
                    c.id,
                    c.title,
                    c.slug,
                    c.thumbnail_url,
                    c.price,
                    c.difficulty,
                    c.duration_weeks,
                    c.avg_rating,
                    c.total_reviews,
                    c.total_students,
                    i.name AS institution_name,
                    cat.name AS category_name,
                    COUNT(DISTINCT e.id) AS total_enrollments,
                    ROUND(AVG(e.progress_percent), 2) AS avg_progress
                FROM courses c
                LEFT JOIN institutions i ON c.institution_id = i.id
                LEFT JOIN categories cat ON c.category_id = cat.id
                LEFT JOIN enrollments e ON e.course_id = c.id
                WHERE c.is_published = 1 
                  AND c.deleted_at IS NULL
                  AND (p_category_id IS NULL OR c.category_id = p_category_id)
                GROUP BY c.id, c.title, c.slug, c.thumbnail_url, c.price, c.difficulty,
                         c.duration_weeks, c.avg_rating, c.total_reviews, c.total_students,
                         i.name, cat.name
                ORDER BY c.total_students DESC, c.avg_rating DESC
                LIMIT p_limit;
            END
        ");

        // ──────────────────────────────────────── sp_calculate_completion_rate ───────────────────────────────────────
        // Calculate completion rate for a course
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_calculate_completion_rate;
            CREATE PROCEDURE sp_calculate_completion_rate(
                IN p_course_id BIGINT UNSIGNED
            )
            BEGIN
                DECLARE v_total_enrollments INT DEFAULT 0;
                DECLARE v_completed_enrollments INT DEFAULT 0;
                DECLARE v_completion_rate DECIMAL(5, 2) DEFAULT 0;

                SELECT COUNT(*) INTO v_total_enrollments
                FROM enrollments
                WHERE course_id = p_course_id;

                SELECT COUNT(*) INTO v_completed_enrollments
                FROM enrollments
                WHERE course_id = p_course_id AND status = 'completed';

                IF v_total_enrollments > 0 THEN
                    SET v_completion_rate = (v_completed_enrollments / v_total_enrollments) * 100;
                END IF;

                SELECT 
                    p_course_id AS course_id,
                    v_total_enrollments AS total_enrollments,
                    v_completed_enrollments AS completed_enrollments,
                    v_completion_rate AS completion_rate_percent;
            END
        ");

        // ──────────────────────────────────────── sp_refund_enrollment ───────────────────────────────────────
        // Refund an enrollment and update payment status
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_refund_enrollment;
            CREATE PROCEDURE sp_refund_enrollment(
                IN p_enrollment_id BIGINT UNSIGNED,
                IN p_reason VARCHAR(255)
            )
            BEGIN
                DECLARE v_payment_id BIGINT UNSIGNED;
                DECLARE v_user_id BIGINT UNSIGNED;
                DECLARE v_course_id BIGINT UNSIGNED;
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK;
                    RESIGNAL;
                END;

                -- Get enrollment details
                SELECT payment_id, user_id, course_id INTO v_payment_id, v_user_id, v_course_id
                FROM enrollments
                WHERE id = p_enrollment_id
                LIMIT 1;

                START TRANSACTION;

                    -- Update enrollment status
                    UPDATE enrollments
                    SET status = 'refunded'
                    WHERE id = p_enrollment_id;

                    -- Update payment status
                    UPDATE payments
                    SET status = 'refunded', updated_at = NOW()
                    WHERE id = v_payment_id;

                    -- Log enrollment history
                    INSERT INTO enrollment_history (
                        enrollment_id, status_from, status_to, reason, changed_by, notes, created_at, updated_at
                    ) VALUES (
                        p_enrollment_id, 'active', 'refunded', 'refund_requested', NULL, p_reason, NOW(), NOW()
                    );

                COMMIT;

                -- Return confirmation
                SELECT p_enrollment_id AS enrollment_id, 'refunded' AS new_status;
            END
        ");

        // ──────────────────────────────────────── sp_generate_analytics_snapshot ───────────────────────────────────────
        // Generate daily analytics snapshot for reporting and dashboard
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_generate_analytics_snapshot;
            CREATE PROCEDURE sp_generate_analytics_snapshot(
                IN p_snapshot_date DATE
            )
            BEGIN
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK;
                    RESIGNAL;
                END;

                START TRANSACTION;

                    -- Insert or update course daily stats
                    INSERT INTO course_daily_stats (course_id, date, enrollments_count, completed_count, revenue_amount, avg_rating)
                    SELECT
                        c.id,
                        p_snapshot_date,
                        COUNT(DISTINCT e.id),
                        COUNT(DISTINCT CASE WHEN e.status = 'completed' THEN e.id END),
                        COALESCE(SUM(CASE WHEN p.status = 'paid' THEN pi.price ELSE 0 END), 0),
                        ROUND(AVG(r.rating), 2)
                    FROM courses c
                    LEFT JOIN enrollments e ON e.course_id = c.id AND DATE(e.created_at) = p_snapshot_date
                    LEFT JOIN payments p ON p.id = e.payment_id AND DATE(p.created_at) = p_snapshot_date
                    LEFT JOIN payment_items pi ON pi.payment_id = p.id AND pi.course_id = c.id
                    LEFT JOIN reviews r ON r.course_id = c.id AND DATE(r.created_at) = p_snapshot_date
                    WHERE c.deleted_at IS NULL
                    GROUP BY c.id
                    ON DUPLICATE KEY UPDATE
                        enrollments_count = VALUES(enrollments_count),
                        completed_count = VALUES(completed_count),
                        revenue_amount = VALUES(revenue_amount),
                        avg_rating = VALUES(avg_rating);

                COMMIT;

                SELECT CONCAT('Analytics snapshot generated for ', p_snapshot_date) AS result;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop stored procedures
        DB::statement('DROP PROCEDURE IF EXISTS sp_generate_analytics_snapshot');
        DB::statement('DROP PROCEDURE IF EXISTS sp_refund_enrollment');
        DB::statement('DROP PROCEDURE IF EXISTS sp_calculate_completion_rate');
        DB::statement('DROP PROCEDURE IF EXISTS sp_get_top_courses');
        DB::statement('DROP PROCEDURE IF EXISTS sp_get_student_learning_path');
        DB::statement('DROP PROCEDURE IF EXISTS sp_get_instructor_revenue');
        DB::statement('DROP PROCEDURE IF EXISTS sp_get_course_stats');

        // Drop views
        DB::statement('DROP VIEW IF EXISTS v_latest_user_reviews');
        DB::statement('DROP VIEW IF EXISTS v_course_completion_stats');
        DB::statement('DROP VIEW IF EXISTS v_top_courses_by_enrollment');
        DB::statement('DROP VIEW IF EXISTS v_student_learning_progress');
        DB::statement('DROP VIEW IF EXISTS v_instructor_revenue');
        DB::statement('DROP VIEW IF EXISTS v_active_enrollments');
    }
};
