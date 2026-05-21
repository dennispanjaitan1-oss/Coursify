<?php
// Comprehensive analysis of courses and categories

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Course;
use App\Models\Category;

echo "=== COMPREHENSIVE COURSE ANALYSIS ===\n\n";

// 1. Total courses
$totalCourses = Course::withTrashed()->count();
$validCourses = Course::withTrashed()->whereNotNull('category_id')->count();
$nullCategoryCourses = Course::withTrashed()->whereNull('category_id')->count();

echo "1. COURSES STATUS:\n";
echo "   Total courses (with trashed): $totalCourses\n";
echo "   Courses with category_id: $validCourses\n";
echo "   Courses with NULL category_id: $nullCategoryCourses\n";

// 2. Get all category IDs that exist
$existingCategoryIds = Category::pluck('id')->toArray();
$totalCategories = count($existingCategoryIds);

echo "\n2. CATEGORIES:\n";
echo "   Total categories: $totalCategories\n";

// 3. Find valid vs invalid category assignments
$validCategoryAssignments = Course::withTrashed()
    ->whereIn('category_id', $existingCategoryIds)
    ->count();

$invalidCategoryAssignments = Course::withTrashed()
    ->whereNotNull('category_id')
    ->whereNotIn('category_id', $existingCategoryIds)
    ->count();

echo "\n3. COURSE-CATEGORY RELATIONSHIPS:\n";
echo "   Courses with VALID category_id: $validCategoryAssignments\n";
echo "   Courses with INVALID category_id: $invalidCategoryAssignments\n";
echo "   Courses with NULL category_id: $nullCategoryCourses\n";

// 4. Double check the math
$totalCheck = $validCategoryAssignments + $invalidCategoryAssignments + $nullCategoryCourses;
echo "\n4. MATH CHECK:\n";
echo "   Valid + Invalid + NULL = $totalCheck (should equal $totalCourses)\n";

// 5. Count courses by valid categories (with hierarchy)
$validCoursesInCat = 0;
$categories = Category::all();

foreach ($categories as $cat) {
    $coursesInCat = $cat->courses()->withTrashed()->count();
    if ($coursesInCat > 0) {
        $validCoursesInCat += $coursesInCat;
    }
}

echo "\n5. COURSES REACHABLE BY CATEGORY RELATIONSHIPS:\n";
echo "   Courses found via category relationships: $validCoursesInCat\n";

echo "\n=== SUMMARY ===\n";
echo "✓ Courses with valid categories: $validCategoryAssignments\n";
echo "✗ Courses with invalid categories (orphaned): $invalidCategoryAssignments\n";
echo "✗ Courses with NULL category: $nullCategoryCourses\n";
echo "Total orphaned + NULL: " . ($invalidCategoryAssignments + $nullCategoryCourses) . "\n";
