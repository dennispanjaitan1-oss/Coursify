<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Str;

echo "Starting auto-assignment of orphaned courses...\n";

// 1. Ensure 'Uncategorized' category exists
$uncategorized = Category::firstOrCreate(
    ['slug' => 'uncategorized'],
    [
        'name' => 'Uncategorized',
        'icon' => 'fas fa-question'
    ]
);

// 2. Get all valid categories
$validCategories = Category::all();
$validCategoryIds = $validCategories->pluck('id')->toArray();
echo "Found " . count($validCategories) . " valid categories.\n";

// 3. Get orphaned courses
$orphanedCourses = Course::whereNotIn('category_id', $validCategoryIds)
                         ->orWhereNull('category_id')
                         ->get();
echo "Found " . $orphanedCourses->count() . " orphaned courses.\n";

$mappedCount = 0;
$uncategorizedCount = 0;

foreach ($orphanedCourses as $course) {
    $assigned = false;
    $title = strtolower($course->title);
    $desc = strtolower($course->short_description ?? '');
    $textToMatch = $title . ' ' . $desc;

    // Simple keyword matching heuristics
    // Could try to find category names within the course text
    $bestMatchId = null;
    
    // Some hardcoded mappings for common ones like CS50 -> Computer Science
    if (Str::contains($textToMatch, ['cs50', 'programming', 'developer', 'software', 'coding'])) {
        // find a category related to Computer Science or Web Development
        $cat = $validCategories->filter(function($c) {
            return Str::contains(strtolower($c->name), ['computer science', 'development', 'software', 'programming', 'web']);
        })->first();
        if ($cat) $bestMatchId = $cat->id;
    }
    
    if (!$bestMatchId) {
        // Try exact/partial matching of category names in the title
        foreach ($validCategories as $category) {
            $catName = strtolower($category->name);
            // Ignore very short category names to prevent false positives
            if (strlen($catName) > 3 && Str::contains($textToMatch, $catName)) {
                $bestMatchId = $category->id;
                break;
            }
        }
    }

    if ($bestMatchId) {
        $course->category_id = $bestMatchId;
        $mappedCount++;
        $assigned = true;
    } else {
        $course->category_id = $uncategorized->id;
        $uncategorizedCount++;
        $assigned = true;
    }

    if ($assigned) {
        $course->save();
    }
}

echo "Done!\n";
echo "Successfully mapped $mappedCount courses to valid categories.\n";
echo "Assigned $uncategorizedCount courses to 'Uncategorized'.\n";

// Validation check
$remainingOrphaned = Course::whereNotIn('category_id', Category::pluck('id')->toArray())->count();
echo "Remaining orphaned courses (should be 0): $remainingOrphaned\n";
