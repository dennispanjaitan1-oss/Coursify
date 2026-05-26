<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Top stats
        $stats = [
            'revenue'         => Payment::where('status', 'paid')->sum('amount'),
            'total_students'  => User::where('role', 'student')->count(),
            'total_courses'   => Course::count(),
            'total_reviews'   => Review::count(),
            'avg_rating'      => round(Review::avg('rating'), 1),
            'total_enrollments' => Enrollment::count(),
        ];

        // Revenue per bulan (6 bulan terakhir)
        $revenueChart = Payment::where('status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // User activity
        $activity = [
            'students_active'  => User::where('role', 'student')->whereNotNull('email_verified_at')->count(),
            'total_students'   => User::where('role', 'student')->count(),
            'instructors'      => User::where('role', 'instructor')->count(),
            'total_instructors'=> User::where('role', 'instructor')->count(),
            'enrollments'      => Enrollment::where('status', 'active')->count(),
            'total_enrollments'=> Enrollment::count(),
            'paid_payments'    => Payment::where('status', 'paid')->count(),
            'total_payments'   => Payment::count(),
        ];

        // Top courses by enrollment
        $topCourses = Course::withCount('enrollments')
            ->withAvg('reviews', 'rating')
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();

        //         SELECT courses.*,
        //        COUNT(DISTINCT enrollments.id) AS enrollments_count,
        //        AVG(reviews.rating) AS reviews_avg
        // FROM courses
        // LEFT JOIN enrollments ON enrollments.course_id = courses.id
        // LEFT JOIN reviews ON reviews.course_id = courses.id
        // GROUP BY courses.id
        // ORDER BY enrollments_count DESC
        // LIMIT 5;


        return view('admin.analytics', compact('stats', 'revenueChart', 'activity', 'topCourses'));
    }
}