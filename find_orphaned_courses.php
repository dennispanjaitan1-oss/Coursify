<?php
// Find courses with orphaned or invalid category_id

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

echo "=== FINDING ORPHANED COURSES ===\n\n";

// Get all category IDs that exist
$existingCategoryIds = Category::pluck('id')->toArray();

// Find courses with non-existent category_id
$orphanedCourses = Course::withTrashed()
    ->whereNotIn('category_id', $existingCategoryIds)
    ->select('id', 'title', 'category_id')
    ->get();

echo "Courses with INVALID category_id (category doesn't exist):\n";
echo "Count: " . $orphanedCourses->count() . "\n";

if ($orphanedCourses->count() > 0) {
    echo "\nFirst 10 invalid category IDs:\n";
    $invalidIds = $orphanedCourses->pluck('category_id')->unique()->take(10);
    foreach ($invalidIds as $id) {
        $count = $orphanedCourses->where('category_id', $id)->count();
        echo "  - category_id $id: $count courses\n";
    }
    echo "\n";
}

// Also check for soft-deleted categories
$softDeletedCategories = Category::onlyTrashed()->count();
echo "\nSoft-deleted categories: $softDeletedCategories\n";

// Courses in soft-deleted categories
if ($softDeletedCategories > 0) {
    $deletedCategoryIds = Category::onlyTrashed()->pluck('id')->toArray();
    $coursesInDeletedCats = Course::withTrashed()
        ->whereIn('category_id', $deletedCategoryIds)
        ->count();
    echo "Courses in soft-deleted categories: $coursesInDeletedCats\n";
}

// Summary
echo "\n=== SUMMARY ===\n";
echo "Invalid category_id courses: " . $orphanedCourses->count() . "\n";
echo "Total discrepancy: 175\n";
if ($orphanedCourses->count() == 175) {
    echo "✓ Found the issue! All 175 missing courses have invalid category_id.\n";
}
