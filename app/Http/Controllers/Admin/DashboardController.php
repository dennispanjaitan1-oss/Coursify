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
            'pending_courses'=> Course::where('is_published', false)->count(),
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

        return view('admin.dashboard', compact('stats', 'recentUsers', 'topCourses'));
    }
}