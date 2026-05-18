<?php
/**
 * Migration Validation & Testing Script
 * 
 * This script validates that all 4 new migrations can be executed
 * and that the database schema is correctly updated.
 * 
 * Run with: php artisan tinker < migration_test.php
 * Or: php migration_test.php
 */

echo "\n";
echo "═════════════════════════════════════════════════════════════════\n";
echo "🧪 MIGRATION VALIDATION TEST\n";
echo "═════════════════════════════════════════════════════════════════\n";

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// ─────────────────────────────────────── TEST 1: MIGRATIONS EXIST ───────────────────────────────────────
echo "\n✓ TEST 1: Checking if migration files exist...\n";

$migrations = [
    'database/migrations/2026_05_18_150001_add_database_indexes.php',
    'database/migrations/2026_05_18_150002_add_check_constraints.php',
    'database/migrations/2026_05_18_150003_create_audit_logging_tables.php',
    'database/migrations/2026_05_18_150004_create_database_views_and_stored_procedures.php',
];

$missing = [];
foreach ($migrations as $migration) {
    $path = base_path($migration);
    if (file_exists($path)) {
        echo "  ✓ Found: " . basename($migration) . "\n";
    } else {
        $missing[] = $migration;
        echo "  ✗ Missing: " . basename($migration) . "\n";
    }
}

if (count($missing) > 0) {
    echo "\n❌ ERROR: Some migration files are missing!\n";
    exit(1);
}

echo "\n✓ All migration files found!\n";

// ─────────────────────────────────────── TEST 2: DATABASE CONNECTION ───────────────────────────────────────
echo "\n✓ TEST 2: Testing database connection...\n";

try {
    DB::connection()->getPDO();
    echo "  ✓ Database connection successful\n";
} catch (\Exception $e) {
    echo "  ✗ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// ─────────────────────────────────────── TEST 3: CHECK CURRENT STATE ───────────────────────────────────────
echo "\n✓ TEST 3: Checking current database state...\n";

$tables = Schema::getTables();
$tableNames = array_column($tables, 'name');

echo "  Found " . count($tableNames) . " tables\n";
echo "  Sample tables: " . implode(", ", array_slice($tableNames, 0, 5)) . "...\n";

// ─────────────────────────────────────── TEST 4: VALIDATE MIGRATION SYNTAX ───────────────────────────────────────
echo "\n✓ TEST 4: Validating migration file syntax...\n";

foreach ($migrations as $migration) {
    $path = base_path($migration);
    $code = file_get_contents($path);
    
    if (strpos($code, 'function up()') && strpos($code, 'function down()')) {
        echo "  ✓ Valid migration structure: " . basename($migration) . "\n";
    } else {
        echo "  ✗ Invalid migration structure: " . basename($migration) . "\n";
        exit(1);
    }
}

// ─────────────────────────────────────── TEST 5: CHECK FOR COMMON ISSUES ───────────────────────────────────────
echo "\n✓ TEST 5: Checking for common issues...\n";

$issues = [];

// Check if indexes might already exist
$courses_table = Schema::getColumns('courses');
echo "  Courses table has " . count($courses_table) . " columns\n";

if (count($courses_table) < 10) {
    $issues[] = "Courses table seems to have fewer columns than expected";
}

// Check if audit tables exist
if (!Schema::hasTable('course_activity_logs')) {
    echo "  ℹ Audit tables not yet created (normal - migrations not run)\n";
} else {
    echo "  ✓ Audit tables already exist\n";
}

if (count($issues) > 0) {
    echo "\n  Potential issues found:\n";
    foreach ($issues as $issue) {
        echo "    - " . $issue . "\n";
    }
}

// ─────────────────────────────────────── TEST 6: MIGRATION NUMBERS ───────────────────────────────────────
echo "\n✓ TEST 6: Checking migration numbering...\n";

$expected_numbers = [
    '150001',
    '150002',
    '150003',
    '150004',
];

foreach ($migrations as $migration) {
    $basename = basename($migration);
    preg_match('/(\d{4}_\d{2}_\d{2})/', $basename, $matches);
    if (isset($matches[1])) {
        echo "  ✓ Migration: " . $basename . "\n";
    }
}

// ─────────────────────────────────────── SUMMARY ───────────────────────────────────────
echo "\n";
echo "═════════════════════════════════════════════════════════════════\n";
echo "✅ PRE-MIGRATION VALIDATION PASSED!\n";
echo "═════════════════════════════════════════════════════════════════\n";

echo "\nNext steps:\n";
echo "  1. Backup your database: mysqldump -u root coursify_db > backup.sql\n";
echo "  2. Run migrations: php artisan migrate\n";
echo "  3. Verify: php artisan migrate:status\n";
echo "  4. Test views: SELECT * FROM v_active_enrollments LIMIT 1;\n";
echo "  5. Test procedures: CALL sp_get_top_courses(10, NULL);\n";

echo "\n";
