<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AnalyticsController extends Controller
{
    public function index()
{
    $stats = Cache::remember('admin_analytics_stats', 300, function () {
        return [
            'revenue'           => Payment::where('status', 'paid')->sum('amount'),
            'total_students'    => User::where('role', 'student')->count(),
            'total_courses'     => Course::count(),
            'total_reviews'     => Review::count(),
            'avg_rating'        => round(Review::avg('rating') ?? 0, 1),
            'total_enrollments' => Enrollment::count(),
        ];
    });

    $activity = Cache::remember('admin_analytics_activity', 300, function () {
        return [
            'students_active'   => User::where('role', 'student')->whereNotNull('email_verified_at')->count(),
            'total_students'    => User::where('role', 'student')->count(),
            'instructors'       => User::where('role', 'instructor')->count(),
            'total_instructors' => User::where('role', 'instructor')->count(),
            'enrollments'       => Enrollment::where('status', 'active')->count(),
            'total_enrollments' => Enrollment::count(),
            'paid_payments'     => Payment::where('status', 'paid')->count(),
            'total_payments'    => Payment::count(),
        ];
    });

    $topCourses = Cache::remember('admin_analytics_top_courses', 300, function () {
        return Course::withCount('enrollments')
            ->withAvg('reviews', 'rating')
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();
    });

    $rawChart = Cache::remember('admin_analytics_revenue_chart', 300, function () {
        return Payment::where('status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
    });

    $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $maxRevenue = $rawChart->max(fn($item) => (float) data_get($item, 'total', 0));
    $maxRevenue = $maxRevenue > 0 ? $maxRevenue : 1;

    $revenueItems = $rawChart->map(function ($item) use ($maxRevenue, $months) {
        $total = (float) data_get($item, 'total', 0);
        return [
            'total'      => $total,
            'height'     => round(($total / $maxRevenue) * 100),
            'month_label'=> $months[data_get($item, 'month', 1) - 1],
        ];
    });

    $studentPct = $activity['total_students']    > 0 ? round($activity['students_active']  / $activity['total_students']    * 100) : 0;
    $enrollPct  = $activity['total_enrollments'] > 0 ? round($activity['enrollments']      / $activity['total_enrollments'] * 100) : 0;
    $paymentPct = $activity['total_payments']    > 0 ? round($activity['paid_payments']    / $activity['total_payments']    * 100) : 0;
    $instrPct   = $activity['total_instructors'] > 0 ? round($activity['instructors']      / $activity['total_instructors'] * 100) : 0;

    return view('admin.analytics', compact('stats', 'activity', 'topCourses', 'revenueItems', 'studentPct', 'enrollPct', 'paymentPct', 'instrPct'));
}
}