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
                    'category' => $course->category->name ?? 'General',
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

public function messagesApi()
{
    // Kalau belum ada tabel messages, kembalikan array kosong dulu
    return response()->json([]);
}

    // ═══════════════════════════════════════════════════════════
    // Sidebar Navigation Methods
    // ═══════════════════════════════════════════════════════════

    public function students()
    {
        $instructor = Auth::user();
        $courseIds = $instructor->coursesTaught()->pluck('courses.id');

        $students = Enrollment::whereIn('course_id', $courseIds)
            ->with('user', 'course')
            ->distinct('user_id')
            ->get()
            ->groupBy('user_id')
            ->map(function ($enrollments) {
                return [
                    'id' => $enrollments->first()->user_id,
                    'name' => $enrollments->first()->user->name,
                    'email' => $enrollments->first()->user->email,
                    'courses_enrolled' => $enrollments->count(),
                    'joined_at' => $enrollments->first()->created_at,
                ];
            });

        return view('instructor.students', [
            'students' => $students,
            'totalStudents' => $students->count(),
        ]);
    }

    public function messagesView()
    {
        return view('instructor.messages', [
            'messages' => collect(),
        ]);
    }

    public function reviewsView()
    {
        $instructor = Auth::user();
        $courseIds = $instructor->coursesTaught()->pluck('courses.id');

        $reviews = Review::whereIn('course_id', $courseIds)
            ->with(['user', 'course'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('instructor.reviews', [
            'reviews' => $reviews,
        ]);
    }

    // ═══════════════════════════════════════════════════════════
    // Analytics Navigation Methods
    // ═══════════════════════════════════════════════════════════

    public function earnings()
    {
        $instructor = Auth::user();
        $courseIds = $instructor->coursesTaught()->pluck('courses.id');

        $totalRevenue = 0;
        $monthlyRevenue = 0;
        $weeklyRevenue = 0;
        $pendingPayout = 0;

        // Chart data for earnings
        $earningsChart = [
            ['month' => 'Jan', 'earnings' => 0],
            ['month' => 'Feb', 'earnings' => 0],
            ['month' => 'Mar', 'earnings' => 0],
            ['month' => 'Apr', 'earnings' => 0],
            ['month' => 'May', 'earnings' => 0],
            ['month' => 'Jun', 'earnings' => 0],
        ];

        return view('instructor.earnings', [
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'weeklyRevenue' => $weeklyRevenue,
            'pendingPayout' => $pendingPayout,
            'earningsChart' => $earningsChart,
        ]);
    }

    public function performance()
    {
        $instructor = Auth::user();
        $courseIds = $instructor->coursesTaught()->pluck('courses.id');

        $courses = Course::whereIn('id', $courseIds)
            ->with('reviews')
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->get();

        return view('instructor.performance', [
            'courses' => $courses,
        ]);
    }

    public function insights()
    {
        $instructor = Auth::user();
        $courseIds = $instructor->coursesTaught()->pluck('courses.id');

        $insights = [
            'total_courses' => Course::whereIn('id', $courseIds)->count(),
            'total_students' => Enrollment::whereIn('course_id', $courseIds)->distinct('user_id')->count('user_id'),
            'avg_rating' => Review::whereIn('course_id', $courseIds)->avg('rating') ?? 0,
            'total_reviews' => Review::whereIn('course_id', $courseIds)->count(),
        ];

        return view('instructor.insights', $insights);
    }

    // ═══════════════════════════════════════════════════════════
    // Quick Action Methods
    // ═══════════════════════════════════════════════════════════

    public function uploadVideo()
    {
        return view('instructor.upload-video');
    }

    public function addQuiz()
    {
        return view('instructor.add-quiz');
    }

    public function broadcast()
    {
        return view('instructor.broadcast');
    }

    public function withdraw()
    {
        return view('instructor.withdraw');
    }

    public function reports()
    {
        $instructor = Auth::user();
        $courseIds = $instructor->coursesTaught()->pluck('courses.id');

        $courses = Course::whereIn('id', $courseIds)
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->get();

        return view('instructor.reports', [
            'courses' => $courses,
        ]);
    }
}
