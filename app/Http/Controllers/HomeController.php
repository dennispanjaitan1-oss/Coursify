<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Stats untuk hero section
        $stats = [
            'students'    => $this->formatNumber(User::where('role', 'student')->count()) ?: '50K+',
            'courses'     => $this->formatNumber(Course::where('is_published', true)->count()) ?: '500+',
            'instructors' => $this->formatNumber(User::where('role', 'instructor')->count()) ?: '120+',
            'satisfaction' => '98%',
        ];

        // Student count untuk hero badge
        $studentCount = User::where('role', 'student')->count() > 0
            ? User::where('role', 'student')->count() . '+'
            : '50,000+';

        // Categories dengan course count (gunakan data asli jika ada)
        $categories = Cache::remember('home_categories', 3600, function () {
            return Category::withCount(['courses' => function($q) {
                $q->published();
            }])
            ->whereNull('parent_id')
            ->take(8)
            ->get()
            ->map(function($cat) {
                return [
                    'icon'  => $cat->icon ?: 'fa-solid fa-folder-open',
                    'name'  => $cat->name,
                    'slug'  => $cat->slug,
                    'count' => $cat->courses_count,
                ];
            })
            ->toArray();
        });

        // Featured courses (6 kursus terpopuler)
        $featuredCourses = Cache::remember('home_featured_courses', 3600, function () {
            return Course::published()
                ->with(['instructors', 'category'])
                ->withCount('enrollments')
                ->orderBy('enrollments_count', 'desc')
                ->take(6)
                ->get()
                ->map(function($course, $index) {
                    $instructor = $course->instructors->first();
                    return [
                        'icon'       => 'fa-solid fa-graduation-cap',
                        'title'      => $course->title,
                        'category'   => $course->category->name ?? 'General',
                        'instructor' => $instructor ? $instructor->name . ' · ' . ($instructor->headline ?? 'Instructor') : 'Coursify Team',
                        'rating'     => number_format($course->average_rating ?: 4.8, 1),
                        'students'   => $this->formatNumber($course->enrollments_count),
                        'duration'   => $course->duration_weeks . 'w',
                        'price'      => $course->price == 0 ? 'Free' : 'Rp ' . number_format($course->price, 0, ',', '.'),
                        'badge'      => $course->price == 0 ? 'free' : ($index < 2 ? 'bestseller' : 'new'),
                        'thumb'      => ($index % 6) + 1,
                    ];
                })
                ->toArray();
        });

        // Featured instructors
        $instructors = Cache::remember('home_instructors', 3600, function () {
            return User::where('role', 'instructor')
                ->withCount(['coursesTaught'])
                ->take(3)
                ->get()
                ->map(function($inst) {
                    return [
                        'avatar'   => 'fa-solid fa-user-tie',
                        'name'     => $inst->name,
                        'title'    => $inst->headline ?: 'Expert Instructor',
                        'tags'     => ['Teaching', 'Expert', 'Mentor'],
                        'courses'  => (string) $inst->courses_taught_count,
                        'students' => $this->formatNumber(rand(10000, 100000)),
                    ];
                })
                ->toArray();
        });

        return view('home.index', compact(
            'stats',
            'studentCount',
            'categories',
            'featuredCourses',
            'instructors'
        ));
    }

    /**
     * Format angka jadi ringkasan (1.2K, 50K+, etc)
     */
    private function formatNumber($num): string
    {
        if ($num === 0) return '0';
        if ($num < 1000) return (string) $num;
        if ($num < 10000) return number_format($num / 1000, 1) . 'K';
        return floor($num / 1000) . 'K+';
    }
}