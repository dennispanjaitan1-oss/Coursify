<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $instructor = Auth::user();

        // ═══ Ambil course IDs milik instructor ini (via pivot) ═══
        $courseIds = $instructor->coursesTaught()->pluck('courses.id'); 
        // Pastikan User model punya relationship courses() — lihat catatan di bawah

        // Stats
        $publishedCount = Course::whereIn('id', $courseIds)
            ->where('is_published', true)
            ->count();

        $studentsCount = Enrollment::whereIn('course_id', $courseIds)
            ->distinct('user_id')
            ->count('user_id');

        $avgRating = Review::whereIn('course_id', $courseIds)
            ->avg('rating') ?? 0;

        $reviewsCount = Review::whereIn('course_id', $courseIds)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        // Revenue — dari payment_items atau enrollments (sesuaikan dengan skema Anda)
        $totalRevenue = 0;   // Sesuaikan jika ada tabel payments
        $monthlyRevenue = 0; // Sesuaikan
        $pendingPayout = 0;

        // Top Courses
        $topCourses = Course::whereIn('id', $courseIds)
            ->where('is_published', true)
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(4)
            ->get()
            ->map(function ($course, $index) {
                return [
                    'rank' => $index + 1,
                    'title' => $course->title,
                    'students' => $course->enrollments_count,
                    'revenue' => 0,
                    'category' => $course->category->name ?? 'Uncategorized',
                    'icon' => 'fa-book',
                    'gradient' => 'purple',
                ];
            });

        // Managed Courses (for table)
        $manageCourses = Course::whereIn('id', $courseIds)
            ->with(['category', 'reviews'])
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('updated_at')
            ->take(5)
            ->get();

        // Recent Enrollments
        $enrollments = Enrollment::whereIn('course_id', $courseIds)
            ->with(['user', 'course'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Recent Reviews
        $reviews = Review::whereIn('course_id', $courseIds)
            ->with(['user', 'course'])
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        // Messages — skip jika belum ada tabel messages
        $messages = collect();
        $unreadCount = 0;

        // Revenue chart
        $revenueChart = [
            ['label' => 'Week 1', 'value' => 0],
            ['label' => 'Week 2', 'value' => 0],
            ['label' => 'Week 3', 'value' => 0],
            ['label' => 'Week 4', 'value' => 0],
        ];

        return view('instructor.dashboard', compact(
            'instructor',
            'publishedCount',
            'studentsCount',
            'avgRating',
            'reviewsCount',
            'totalRevenue',
            'monthlyRevenue',
            'pendingPayout',
            'topCourses',
            'manageCourses',
            'enrollments',
            'reviews',
            'messages',
            'unreadCount',
            'revenueChart'
        ));
    }

    public function stats()
{
    $instructor = Auth::user();
    $courseIds = $instructor->coursesTaught()->pluck('courses.id');

    $avgRating = Review::whereIn('course_id', $courseIds)->avg('rating') ?? 0;

    return response()->json([
        'publishedCount' => Course::whereIn('id', $courseIds)->where('is_published', true)->count(),
        'studentsCount'  => Enrollment::whereIn('course_id', $courseIds)->distinct('user_id')->count('user_id'),
        'avgRating'      => round($avgRating, 1),
    ]);
}

public function reviews()
{
    $instructor = Auth::user();
    $courseIds = $instructor->coursesTaught()->pluck('courses.id');

    $reviews = Review::whereIn('course_id', $courseIds)
        ->with(['user', 'course'])
        ->latest()
        ->take(10)
        ->get()
        ->map(fn($r) => [
            'user_name'    => $r->user->name,
            'course_title' => $r->course->title,
            'rating'       => $r->rating,
            'comment'      => $r->comment,
            'created_at'   => $r->created_at->diffForHumans(),
        ]);

    return response()->json($reviews);
}

public function enrollments()
{
    $instructor = Auth::user();
    $courseIds = $instructor->coursesTaught()->pluck('courses.id');

    $enrollments = Enrollment::whereIn('course_id', $courseIds)
        ->with(['user', 'course'])
        ->latest()
        ->take(10)
        ->get()
        ->map(fn($e) => [
            'student_name' => $e->user->name,
            'course_title' => $e->course->title,
            'created_at'   => $e->created_at->diffForHumans(),
        ]);

    return response()->json($enrollments);
}

public function messages()
{
    // Kalau belum ada tabel messages, kembalikan array kosong dulu
    return response()->json([]);
}
}
