<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $publishedCount = 0;
        $studentsCount = '0';
        $avgRating = '0.0';
        $reviewsCount = 0;

        try {
            $courseIds = $user->coursesTaught()->pluck('courses.id');

            $publishedCount = $user->coursesTaught()
                                   ->where('is_published', true)
                                   ->count();

            $studentsCount = Enrollment::whereIn('course_id', $courseIds)->count();
            $studentsCount = $studentsCount > 1000
                ? number_format($studentsCount / 1000, 1) . 'K'
                : (string) $studentsCount;

            $avgRating = Review::whereIn('course_id', $courseIds)->avg('rating');
            $avgRating = number_format($avgRating ?: 4.8, 1);

            $reviewsCount = Review::whereIn('course_id', $courseIds)
                                  ->where('created_at', '>=', now()->subDays(7))
                                  ->count();
        } catch (\Exception $e) {
            // Defaults
        }

        return view('instructor.dashboard', compact(
            'publishedCount',
            'studentsCount',
            'avgRating',
            'reviewsCount'
        ));
    }
}