<?php
// Quick script to check courses without categories

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Course;
use App\Models\Category;

echo "=== COURSE CATEGORY ANALYSIS ===\n\n";

// Total courses
$totalCourses = Course::withTrashed()->count();
echo "Total courses (including trashed): $totalCourses\n";

// Courses without category
$coursesWithoutCat = Course::withTrashed()->whereNull('category_id')->count();
echo "Courses WITHOUT category_id: $coursesWithoutCat\n";

// Courses with category
$coursesWithCat = Course::withTrashed()->whereNotNull('category_id')->count();
echo "Courses WITH category_id: $coursesWithCat\n\n";

// Sum of courses across all categories
$categorySum = 0;
$categories = Category::with('children')->get();

foreach ($categories as $parent) {
    $parentCount = $parent->courses()->withTrashed()->count();
    if ($parentCount > 0) {
        echo "- {$parent->name} (parent): $parentCount courses\n";
    }
    $categorySum += $parentCount;
    
    foreach ($parent->children as $child) {
        $childCount = $child->courses()->withTrashed()->count();
        if ($childCount > 0) {
            echo "  - {$child->name} (child): $childCount courses\n";
        }
        $categorySum += $childCount;
    }
}

echo "\nTotal from category sum: $categorySum\n";
echo "Difference (uncategorized): " . ($totalCourses - $categorySum) . "\n";
