<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        // ─────────────────────────────────────────────────────────────
        // PERSIAPAN: Tambah kolom avg_rating, total_reviews,
        // total_students ke tabel courses (belum ada di migration awal)
        // ─────────────────────────────────────────────────────────────
        Schema::table('courses', function (Blueprint $table) {
            $table->decimal('avg_rating', 3, 2)->default(0)->after('is_published');
            $table->integer('total_reviews')->default(0)->after('avg_rating');
            $table->integer('total_students')->default(0)->after('total_reviews');
        });

        // ─────────────────────────────────────────────────────────────
        // TRIGGER 1 & 2: Update progress_percent di enrollments
        // ketika lesson_progress di-INSERT atau di-UPDATE
        // ─────────────────────────────────────────────────────────────
        DB::unprepared("
            DROP TRIGGER IF EXISTS trg_update_progress_on_insert;
            CREATE TRIGGER trg_update_progress_on_insert
            AFTER INSERT ON lesson_progress
            FOR EACH ROW
            BEGIN
                DECLARE v_course_id  BIGINT UNSIGNED;
                DECLARE v_total      INT DEFAULT 0;
                DECLARE v_done       INT DEFAULT 0;
                DECLARE v_pct        DECIMAL(5,2) DEFAULT 0;

                SELECT s.course_id INTO v_course_id
                FROM lessons l
                JOIN sections s ON l.section_id = s.id
                WHERE l.id = NEW.lesson_id
                LIMIT 1;

                SELECT COUNT(*) INTO v_total
                FROM lessons l
                JOIN sections s ON l.section_id = s.id
                WHERE s.course_id = v_course_id;

                SELECT COUNT(*) INTO v_done
                FROM lesson_progress lp
                JOIN lessons l  ON lp.lesson_id = l.id
                JOIN sections s ON l.section_id = s.id
                WHERE s.course_id   = v_course_id
                  AND lp.user_id    = NEW.user_id
                  AND lp.is_completed = 1;

                IF v_total > 0 THEN
                    SET v_pct = ROUND((v_done / v_total) * 100, 2);
                END IF;

                UPDATE enrollments
                SET
                    progress_percent = v_pct,
                    status = CASE
                        WHEN v_pct >= 100 THEN 'completed'
                        WHEN v_pct > 0   THEN 'active'
                        ELSE status
                    END,
                    completed_at = CASE
                        WHEN v_pct >= 100 AND completed_at IS NULL THEN NOW()
                        WHEN v_pct < 100  THEN NULL
                        ELSE completed_at
                    END
                WHERE user_id   = NEW.user_id
                  AND course_id = v_course_id;
            END
        ");

        DB::unprepared("
            DROP TRIGGER IF EXISTS trg_update_progress_on_update;
            CREATE TRIGGER trg_update_progress_on_update
            AFTER UPDATE ON lesson_progress
            FOR EACH ROW
            BEGIN
                DECLARE v_course_id  BIGINT UNSIGNED;
                DECLARE v_total      INT DEFAULT 0;
                DECLARE v_done       INT DEFAULT 0;
                DECLARE v_pct        DECIMAL(5,2) DEFAULT 0;

                SELECT s.course_id INTO v_course_id
                FROM lessons l
                JOIN sections s ON l.section_id = s.id
                WHERE l.id = NEW.lesson_id
                LIMIT 1;

                SELECT COUNT(*) INTO v_total
                FROM lessons l
                JOIN sections s ON l.section_id = s.id
                WHERE s.course_id = v_course_id;

                SELECT COUNT(*) INTO v_done
                FROM lesson_progress lp
                JOIN lessons l  ON lp.lesson_id = l.id
                JOIN sections s ON l.section_id = s.id
                WHERE s.course_id   = v_course_id
                  AND lp.user_id    = NEW.user_id
                  AND lp.is_completed = 1;

                IF v_total > 0 THEN
                    SET v_pct = ROUND((v_done / v_total) * 100, 2);
                END IF;

                UPDATE enrollments
                SET
                    progress_percent = v_pct,
                    status = CASE
                        WHEN v_pct >= 100 THEN 'completed'
                        WHEN v_pct > 0   THEN 'active'
                        ELSE status
                    END,
                    completed_at = CASE
                        WHEN v_pct >= 100 AND completed_at IS NULL THEN NOW()
                        WHEN v_pct < 100  THEN NULL
                        ELSE completed_at
                    END
                WHERE user_id   = NEW.user_id
                  AND course_id = v_course_id;
            END
        ");

        // ─────────────────────────────────────────────────────────────
        // TRIGGER 3: Auto-issue certificate ketika enrollment
        // statusnya berubah menjadi 'completed'
        // ─────────────────────────────────────────────────────────────
        DB::unprepared("
            DROP TRIGGER IF EXISTS trg_issue_certificate;
            CREATE TRIGGER trg_issue_certificate
            AFTER UPDATE ON enrollments
            FOR EACH ROW
            BEGIN
                IF NEW.status = 'completed' AND OLD.status != 'completed' THEN
                    IF NOT EXISTS (
                        SELECT 1 FROM certificates
                        WHERE user_id   = NEW.user_id
                          AND course_id = NEW.course_id
                    ) THEN
                        INSERT INTO certificates (
                            user_id,
                            course_id,
                            program_id,
                            certificate_number,
                            issued_at,
                            created_at,
                            updated_at
                        ) VALUES (
                            NEW.user_id,
                            NEW.course_id,
                            NULL,
                            CONCAT(
                                'CERT-',
                                YEAR(NOW()),
                                '-',
                                UPPER(SUBSTRING(MD5(CONCAT(NEW.user_id,'-',NEW.course_id,'-',NOW())), 1, 8))
                            ),
                            NOW(),
                            NOW(),
                            NOW()
                        );
                    END IF;
                END IF;
            END
        ");

        // ─────────────────────────────────────────────────────────────
        // TRIGGER 4, 5, 6: Sync avg_rating & total_reviews di courses
        // setiap ada INSERT / UPDATE / DELETE di reviews
        // ─────────────────────────────────────────────────────────────
        DB::unprepared("
            DROP TRIGGER IF EXISTS trg_rating_after_insert;
            CREATE TRIGGER trg_rating_after_insert
            AFTER INSERT ON reviews
            FOR EACH ROW
            BEGIN
                UPDATE courses
                SET
                    avg_rating    = (SELECT ROUND(AVG(rating), 2) FROM reviews WHERE course_id = NEW.course_id),
                    total_reviews = (SELECT COUNT(*)               FROM reviews WHERE course_id = NEW.course_id)
                WHERE id = NEW.course_id;
            END
        ");

        DB::unprepared("
            DROP TRIGGER IF EXISTS trg_rating_after_update;
            CREATE TRIGGER trg_rating_after_update
            AFTER UPDATE ON reviews
            FOR EACH ROW
            BEGIN
                UPDATE courses
                SET
                    avg_rating    = (SELECT ROUND(AVG(rating), 2) FROM reviews WHERE course_id = NEW.course_id),
                    total_reviews = (SELECT COUNT(*)               FROM reviews WHERE course_id = NEW.course_id)
                WHERE id = NEW.course_id;
            END
        ");

        DB::unprepared("
            DROP TRIGGER IF EXISTS trg_rating_after_delete;
            CREATE TRIGGER trg_rating_after_delete
            AFTER DELETE ON reviews
            FOR EACH ROW
            BEGIN
                UPDATE courses
                SET
                    avg_rating    = COALESCE((SELECT ROUND(AVG(rating), 2) FROM reviews WHERE course_id = OLD.course_id), 0),
                    total_reviews = (SELECT COUNT(*) FROM reviews WHERE course_id = OLD.course_id)
                WHERE id = OLD.course_id;
            END
        ");

        // ─────────────────────────────────────────────────────────────
        // TRIGGER 7 & 8: Sync total_students di courses
        // setiap ada enrollment baru atau enrollment dihapus
        // ─────────────────────────────────────────────────────────────
        DB::unprepared("
            DROP TRIGGER IF EXISTS trg_students_after_enroll;
            CREATE TRIGGER trg_students_after_enroll
            AFTER INSERT ON enrollments
            FOR EACH ROW
            BEGIN
                UPDATE courses
                SET total_students = total_students + 1
                WHERE id = NEW.course_id;
            END
        ");

        DB::unprepared("
            DROP TRIGGER IF EXISTS trg_students_after_unenroll;
            CREATE TRIGGER trg_students_after_unenroll
            AFTER DELETE ON enrollments
            FOR EACH ROW
            BEGIN
                UPDATE courses
                SET total_students = GREATEST(total_students - 1, 0)
                WHERE id = OLD.course_id;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS trg_students_after_unenroll");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_students_after_enroll");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_rating_after_delete");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_rating_after_update");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_rating_after_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_issue_certificate");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_update_progress_on_update");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_update_progress_on_insert");

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['avg_rating', 'total_reviews', 'total_students']);
        });
    }
};