<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ─────────────────────────────────────────────────────────────
        // STORED PROCEDURE 1: sp_enroll_student
        // Membuat payment + enrollment + payment_item dalam 1 transaksi
        // ─────────────────────────────────────────────────────────────
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_enroll_student;
            CREATE PROCEDURE sp_enroll_student(
                IN p_user_id   BIGINT UNSIGNED,
                IN p_course_id BIGINT UNSIGNED,
                IN p_method    VARCHAR(50)
            )
            BEGIN
                DECLARE v_price        DECIMAL(10,2);
                DECLARE v_payment_id   BIGINT UNSIGNED;
                DECLARE v_status       VARCHAR(20);
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK;
                    RESIGNAL;
                END;

                -- Ambil harga course
                SELECT price INTO v_price
                FROM courses
                WHERE id = p_course_id
                LIMIT 1;

                -- Tentukan status payment
                SET v_status = IF(v_price = 0, 'completed', 'pending');

                START TRANSACTION;

                    -- Buat payment
                    INSERT INTO payments (user_id, amount, method, status, paid_at, created_at, updated_at)
                    VALUES (
                        p_user_id,
                        v_price,
                        p_method,
                        v_status,
                        IF(v_price = 0, NOW(), NULL),
                        NOW(),
                        NOW()
                    );

                    SET v_payment_id = LAST_INSERT_ID();

                    -- Buat payment_item
                    INSERT INTO payment_items (payment_id, course_id, program_id, item_type, price, created_at, updated_at)
                    VALUES (v_payment_id, p_course_id, NULL, 'course', v_price, NOW(), NOW());

                    -- Buat enrollment
                    INSERT INTO enrollments (user_id, course_id, payment_id, type, status, progress_percent, created_at, updated_at)
                    VALUES (p_user_id, p_course_id, v_payment_id, 'audit', 'active', 0.00, NOW(), NOW());

                COMMIT;
            END
        ");

        // ─────────────────────────────────────────────────────────────
        // STORED PROCEDURE 2: sp_get_course_stats
        // Mengembalikan statistik lengkap sebuah course
        // ─────────────────────────────────────────────────────────────
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_get_course_stats;
            CREATE PROCEDURE sp_get_course_stats(
                IN p_course_id BIGINT UNSIGNED
            )
            BEGIN
                SELECT
                    c.id                                        AS course_id,
                    c.title,
                    COUNT(DISTINCT e.id)                        AS total_enrollments,
                    ROUND(AVG(r.rating), 2)                     AS avg_rating,
                    COUNT(DISTINCT r.id)                        AS total_reviews,
                    COALESCE(SUM(pi.price), 0)                  AS total_revenue,
                    ROUND(
                        COUNT(DISTINCT CASE WHEN e.status = 'completed' THEN e.id END)
                        / NULLIF(COUNT(DISTINCT e.id), 0) * 100
                    , 2)                                        AS completion_rate_pct
                FROM courses c
                LEFT JOIN enrollments  e  ON e.course_id  = c.id
                LEFT JOIN reviews      r  ON r.course_id  = c.id
                LEFT JOIN payment_items pi ON pi.course_id = c.id
                WHERE c.id = p_course_id
                GROUP BY c.id, c.title;
            END
        ");

        // ─────────────────────────────────────────────────────────────
        // STORED PROCEDURE 3: sp_get_instructor_revenue
        // Mengembalikan rekap revenue per instruktur
        // ─────────────────────────────────────────────────────────────
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_get_instructor_revenue;
            CREATE PROCEDURE sp_get_instructor_revenue(
                IN p_user_id BIGINT UNSIGNED
            )
            BEGIN
                SELECT
                    u.id                            AS instructor_id,
                    u.name                          AS instructor_name,
                    COUNT(DISTINCT c.id)            AS total_courses,
                    COUNT(DISTINCT e.id)            AS total_students,
                    COALESCE(SUM(pi.price), 0)      AS total_revenue,
                    ROUND(AVG(r.rating), 2)         AS avg_rating
                FROM users u
                JOIN course_instructors ci ON ci.user_id   = u.id
                JOIN courses            c  ON c.id         = ci.course_id
                LEFT JOIN enrollments   e  ON e.course_id  = c.id
                LEFT JOIN payment_items pi ON pi.course_id = c.id
                LEFT JOIN reviews       r  ON r.course_id  = c.id
                WHERE u.id = p_user_id
                GROUP BY u.id, u.name;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_instructor_revenue");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_course_stats");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_enroll_student");
    }
};