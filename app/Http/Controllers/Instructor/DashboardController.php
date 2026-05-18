<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Review;
use App\Models\Payment;

class DashboardController extends Controller
{
    private function getCourseIds($instructor)
    {
        if (!$instructor) return collect();
        $courseIds = $instructor->coursesTaught()->pluck('courses.id'); 
        
        // Dynamic fallback: Jika instruktur demo tidak punya course, hubungkan ke 5 course pertama
        if ($courseIds->isEmpty()) {
            $demoCourses = Course::take(5)->pluck('id');
            if ($demoCourses->isNotEmpty()) {
                $instructor->coursesTaught()->syncWithoutDetaching($demoCourses);
                $courseIds = $instructor->coursesTaught()->pluck('courses.id');
            }
        }
        return $courseIds;
    }

    public function index()
    {
        $instructor = Auth::user();
        $courseIds = $this->getCourseIds($instructor);

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

        // Real Revenue — dari payments table
        $totalRevenue = Payment::whereHas('enrollments', function ($query) use ($courseIds) {
            $query->whereIn('course_id', $courseIds);
        })->where('status', 'paid')->sum('amount');

        $monthlyRevenue = Payment::whereHas('enrollments', function ($query) use ($courseIds) {
            $query->whereIn('course_id', $courseIds);
        })->where('status', 'paid')
          ->where('paid_at', '>=', now()->startOfMonth())
          ->sum('amount');

        $pendingPayout = Payment::whereHas('enrollments', function ($query) use ($courseIds) {
            $query->whereIn('course_id', $courseIds);
        })->where('status', 'pending')->sum('amount');

        // Top Courses
        $topCourses = Course::whereIn('id', $courseIds)
            ->where('is_published', true)
            ->with(['category', 'enrollments.payment'])
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(4)
            ->get()
            ->map(function ($course, $index) {
                $revenue = $course->enrollments
                    ->where('payment.status', 'paid')
                    ->sum('payment.amount');
                return [
                    'rank' => $index + 1,
                    'title' => $course->title,
                    'students' => $course->enrollments_count,
                    'revenue' => $revenue,
                    'category' => $course->category->name ?? 'Uncategorized',
                    'icon' => 'fa-book',
                    'gradient' => 'purple',
                ];
            });

        // Managed Courses (for table)
        $manageCourses = Course::whereIn('id', $courseIds)
            ->with(['category', 'reviews', 'enrollments.payment'])
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('updated_at')
            ->take(5)
            ->get()
            ->map(function ($course) {
                $course->lifetime_revenue = $course->enrollments
                    ->where('payment.status', 'paid')
                    ->sum('payment.amount');
                return $course;
            });

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

        // Dynamic weekly revenue chart
        $revenueChart = [];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = now()->subWeeks($i)->startOfWeek();
            $endOfWeek = now()->subWeeks($i)->endOfWeek();

            $weekRevenue = Payment::whereHas('enrollments', function ($query) use ($courseIds) {
                $query->whereIn('course_id', $courseIds);
            })->where('status', 'paid')
              ->whereBetween('paid_at', [$startOfWeek, $endOfWeek])
              ->sum('amount');

            $revenueChart[] = [
                'label' => 'Wk ' . (4 - $i),
                'value' => (float) $weekRevenue,
            ];
        }

        // SVG Path Dynamic Generation
        $maxVal = collect($revenueChart)->max('value');
        $points = [];
        $svgPath = "";
        $svgFillPath = "";
        $xCoords = [40, 160, 280, 400];
        
        foreach ($revenueChart as $index => $week) {
            $x = $xCoords[$index];
            $y = 130; // base y coordinate (zero revenue)
            if ($maxVal > 0) {
                $y = 130 - (($week['value'] / $maxVal) * 100);
            }
            $points[] = ['x' => $x, 'y' => $y];
        }

        if (!empty($points)) {
            $pathParts = [];
            foreach ($points as $p) {
                $pathParts[] = "L {$p['x']},{$p['y']}";
            }
            $svgPath = "M 0,130 " . implode(" ", $pathParts);
            $svgFillPath = $svgPath . " L 400,180 L 0,180 Z";
        } else {
            $svgPath = "M 0,130 L 400,130";
            $svgFillPath = "M 0,130 L 400,130 L 400,180 L 0,180 Z";
        }

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
            'revenueChart',
            'svgPath',
            'svgFillPath',
            'points'
        ));
    }

    public function stats()
    {
        $instructor = Auth::user();
        $courseIds = $this->getCourseIds($instructor);

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
        $courseIds = $this->getCourseIds($instructor);

        $reviews = Review::whereIn('course_id', $courseIds)
            ->with(['user', 'course'])
            ->latest()
            ->take(10)
            ->get()
            ->map(fn($r) => [
                'user_name'    => $r->user->name ?? 'Student',
                'course_title' => $r->course->title ?? 'Course',
                'rating'       => $r->rating,
                'comment'      => $r->comment,
                'created_at'   => $r->created_at->diffForHumans(),
            ]);

        return response()->json($reviews);
    }

    public function enrollments()
    {
        $instructor = Auth::user();
        $courseIds = $this->getCourseIds($instructor);

        $enrollments = Enrollment::whereIn('course_id', $courseIds)
            ->with(['user', 'course'])
            ->latest()
            ->take(10)
            ->get()
            ->map(fn($e) => [
                'student_name' => $e->user->name ?? 'Student',
                'course_title' => $e->course->title ?? 'Course',
                'created_at'   => $e->created_at->diffForHumans(),
            ]);

        return response()->json($enrollments);
    }

    public function messages()
    {
        return response()->json([]);
    }
}
