<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'    => User::count(),
            'total_courses'  => Course::count(),
            'pending_courses'=> Course::pendingApproval()->count(),
            'revenue'        => Payment::where('status', 'paid')->sum('amount'),
        ];

        // Recent users
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();

        // Top courses by enrollment
        $topCourses = Course::withCount('enrollments')
            ->withAvg('reviews', 'rating')
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();
// SELECT courses.*,
// COUNT(DISTINCT enrollments.id) AS enrollments_count,
// AVG(reviews.rating) AS reviews_avg
// FROM courses
// LEFT JOIN enrollments ON enrollments.course_id = courses.id
// LEFT JOIN reviews ON reviews.course_id = courses.id
// GROUP BY courses.id
// ORDER BY enrollments_count DESC
// LIMIT 5;

        return view('admin.dashboard', compact('stats', 'recentUsers', 'topCourses'));
    }
}
