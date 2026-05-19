<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // SP 1: Enroll student dalam 1 transaksi atomik
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_enroll_student");
        DB::unprepared("
            CREATE PROCEDURE sp_enroll_student(
                IN p_user_id   BIGINT UNSIGNED,
                IN p_course_id BIGINT UNSIGNED,
                IN p_method    VARCHAR(50)
            )
            BEGIN
                DECLARE v_price      DECIMAL(10,2);
                DECLARE v_payment_id BIGINT UNSIGNED;
                DECLARE v_status     VARCHAR(20);
                DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN ROLLBACK; RESIGNAL; END;

                SELECT price INTO v_price FROM courses WHERE id = p_course_id LIMIT 1;
                SET v_status = IF(v_price = 0, 'paid', 'pending');

                START TRANSACTION;
                    INSERT INTO payments (user_id, amount, method, status, paid_at, created_at, updated_at)
                    VALUES (p_user_id, v_price, p_method, v_status, IF(v_price=0,NOW(),NULL), NOW(), NOW());
                    SET v_payment_id = LAST_INSERT_ID();

                    INSERT INTO payment_items (payment_id, course_id, program_id, item_type, price, created_at, updated_at)
                    VALUES (v_payment_id, p_course_id, NULL, 'course', v_price, NOW(), NOW());

                    INSERT INTO enrollments (user_id, course_id, payment_id, type, status, progress_percent, created_at, updated_at)
                    VALUES (p_user_id, p_course_id, v_payment_id, 'audit', 'active', 0.00, NOW(), NOW());
                COMMIT;
            END
        ");

        // SP 2: Statistik lengkap sebuah course (JOIN 6 tabel)
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_course_stats");
        DB::unprepared("
            CREATE PROCEDURE sp_get_course_stats(IN p_course_id BIGINT UNSIGNED)
            BEGIN
                SELECT
                    c.id AS course_id,
                    c.title,
                    c.price,
                    c.difficulty,
                    c.avg_rating,
                    COUNT(DISTINCT e.id)    AS total_enrollments,
                    COUNT(DISTINCT CASE WHEN e.status='completed' THEN e.id END) AS completed_enrollments,
                    ROUND(
                        COUNT(DISTINCT CASE WHEN e.status='completed' THEN e.id END)
                        / NULLIF(COUNT(DISTINCT e.id),0) * 100
                    ,2) AS completion_rate_pct,
                    COUNT(DISTINCT r.id)    AS total_reviews,
                    COUNT(DISTINCT l.id)    AS total_lessons,
                    COALESCE(SUM(CASE WHEN p.status='paid' THEN pi.price ELSE 0 END),0) AS total_revenue
                FROM courses c
                LEFT JOIN enrollments   e  ON e.course_id  = c.id
                LEFT JOIN reviews       r  ON r.course_id  = c.id
                LEFT JOIN sections      s  ON s.course_id  = c.id
                LEFT JOIN lessons       l  ON l.section_id = s.id
                LEFT JOIN payments      p  ON p.id         = e.payment_id
                LEFT JOIN payment_items pi ON pi.payment_id = p.id AND pi.course_id = c.id
                WHERE c.id = p_course_id
                GROUP BY c.id, c.title, c.price, c.difficulty, c.avg_rating;
            END
        ");

        // SP 3: Revenue per instruktur dengan filter tanggal
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_instructor_revenue");
        DB::unprepared("
            CREATE PROCEDURE sp_get_instructor_revenue(
                IN p_instructor_id BIGINT UNSIGNED,
                IN p_from_date DATE,
                IN p_to_date   DATE
            )
            BEGIN
                SELECT
                    c.id AS course_id, c.title,
                    COUNT(DISTINCT e.id) AS total_enrollments,
                    COUNT(DISTINCT CASE WHEN e.status='completed' THEN e.id END) AS completed,
                    COALESCE(SUM(CASE WHEN p.status='paid' THEN pi.price ELSE 0 END),0) AS total_revenue,
                    ROUND(AVG(r.rating),2) AS avg_rating,
                    COUNT(DISTINCT r.id)   AS total_reviews
                FROM course_instructors ci
                JOIN courses c ON ci.course_id = c.id
                LEFT JOIN enrollments   e  ON e.course_id  = c.id AND DATE(e.created_at) BETWEEN p_from_date AND p_to_date
                LEFT JOIN payments      p  ON p.id         = e.payment_id
                LEFT JOIN payment_items pi ON pi.payment_id = p.id AND pi.course_id = c.id
                LEFT JOIN reviews       r  ON r.course_id  = c.id
                WHERE ci.user_id = p_instructor_id
                GROUP BY c.id, c.title;
            END
        ");

        // SP 4: Hitung completion rate sebuah course
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_calculate_completion_rate");
        DB::unprepared("
            CREATE PROCEDURE sp_calculate_completion_rate(IN p_course_id BIGINT UNSIGNED)
            BEGIN
                DECLARE v_total     INT DEFAULT 0;
                DECLARE v_completed INT DEFAULT 0;
                DECLARE v_rate      DECIMAL(5,2) DEFAULT 0;

                SELECT COUNT(*) INTO v_total     FROM enrollments WHERE course_id = p_course_id;
                SELECT COUNT(*) INTO v_completed FROM enrollments WHERE course_id = p_course_id AND status='completed';
                IF v_total > 0 THEN SET v_rate = (v_completed / v_total) * 100; END IF;

                SELECT p_course_id AS course_id, v_total AS total_enrollments,
                       v_completed AS completed_enrollments, v_rate AS completion_rate_percent;
            END
        ");

        // SP 5: Learning path detail per student per course
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_student_learning_path");
        DB::unprepared("
            CREATE PROCEDURE sp_get_student_learning_path(
                IN p_user_id   BIGINT UNSIGNED,
                IN p_course_id BIGINT UNSIGNED
            )
            BEGIN
                SELECT
                    s.id AS section_id, s.title AS section_title, s.order_index,
                    l.id AS lesson_id,  l.title AS lesson_title, l.type, l.order_index AS lesson_order,
                    l.duration_seconds,
                    COALESCE(lp.is_completed, 0) AS is_completed,
                    lp.updated_at AS completed_at
                FROM courses c
                JOIN sections s ON s.course_id = c.id
                LEFT JOIN lessons l  ON l.section_id = s.id
                LEFT JOIN lesson_progress lp ON lp.lesson_id = l.id AND lp.user_id = p_user_id
                WHERE c.id = p_course_id
                ORDER BY s.order_index, l.order_index;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_student_learning_path");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_calculate_completion_rate");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_instructor_revenue");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_course_stats");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_enroll_student");
    }
};
