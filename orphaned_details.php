<?php
// Get details of orphaned courses

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Course;
use App\Models\Category;

echo "=== ORPHANED COURSES DETAILS ===\n\n";

// Get all category IDs that exist
$existingCategoryIds = Category::pluck('id')->toArray();

// Find all invalid category IDs referenced by courses
$orphanedCategoryIds = Course::withTrashed()
    ->whereNotNull('category_id')
    ->whereNotIn('category_id', $existingCategoryIds)
    ->groupBy('category_id')
    ->selectRaw('category_id, count(*) as course_count')
    ->orderByDesc('course_count')
    ->get();

echo "Invalid category_id references (Top 20):\n";
echo str_pad("Category ID", 15) . str_pad("Count", 10) . "% of total\n";
echo str_repeat("-", 35) . "\n";

$totalOrphaned = $orphanedCategoryIds->sum('course_count');

foreach ($orphanedCategoryIds->take(20) as $item) {
    $percent = round(($item->course_count / 989) * 100, 1);
    echo str_pad($item->category_id, 15) . str_pad($item->course_count, 10) . $percent . "%\n";
}

echo "\nTotal orphaned courses: $totalOrphaned\n";
echo "Total invalid category IDs: " . count($orphanedCategoryIds) . "\n";

// Get a sample of courses from largest orphaned category
$largestOrphanedCatId = $orphanedCategoryIds->first()->category_id;
$sampleCourses = Course::withTrashed()
    ->where('category_id', $largestOrphanedCatId)
    ->select('id', 'title', 'category_id')
    ->limit(5)
    ->get();

echo "\nSample courses with category_id $largestOrphanedCatId:\n";
foreach ($sampleCourses as $course) {
    echo "  - ID: {$course->id}, Title: {$course->title}\n";
}
