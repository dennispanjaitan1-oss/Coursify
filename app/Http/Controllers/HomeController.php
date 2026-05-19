<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
        $categories = Category::withCount(['courses' => function($q) {
            $q->where('is_published', true);
        }])
        ->whereNull('parent_id')
        ->take(8)
        ->get()
        ->map(function($cat) {
            return [
                'icon'  => $cat->icon ?: '📚',
                'name'  => $cat->name,
                'slug'  => $cat->slug,
                'count' => $cat->courses_count,
            ];
        })
        ->toArray();
        $categories = Cache::remember('home_categories', 3600, function () {
            return Category::withCount(['courses' => function($q) {
                $q->published();
            }])
            ->whereNull('parent_id')
            ->take(8)
            ->get()
            ->map(function($cat) {
                $iconMap = [
                    'Architecture'           => 'fa-solid fa-building-columns',
                    'Art'                    => 'fa-solid fa-palette',
                    'Biology'                => 'fa-solid fa-dna',
                    'Business Administration'=> 'fa-solid fa-briefcase',
                    'Chemistry'              => 'fa-solid fa-flask',
                    'Computer Programming'   => 'fa-solid fa-code',
                    'Data Analysis'          => 'fa-solid fa-chart-bar',
                    'Economics'              => 'fa-solid fa-chart-line',
                    'Engineering'            => 'fa-solid fa-gears',
                    'Mathematics'            => 'fa-solid fa-square-root-variable',
                    'Music'                  => 'fa-solid fa-music',
                    'Physics'                => 'fa-solid fa-atom',
                    'Design'                 => 'fa-solid fa-pen-nib',
                    'Marketing'              => 'fa-solid fa-bullhorn',
                    'Language'               => 'fa-solid fa-language',
                    'History'                => 'fa-solid fa-landmark',
                    'Psychology'             => 'fa-solid fa-brain',
                    'Health'                 => 'fa-solid fa-heart-pulse',
                    'Finance'                => 'fa-solid fa-coins',
                    'Law'                    => 'fa-solid fa-scale-balanced',
                    'General'                => 'fa-solid fa-book-open',
                ];
                $iconClass = $cat->icon ?: ($iconMap[$cat->name] ?? 'fa-solid fa-book-open');
                return [
                    'icon'  => '<i class="' . $iconClass . '"></i>',
                    'name'  => $cat->name,
                    'slug'  => $cat->slug,
                    'count' => $cat->courses_count,
                ];
            })
            ->toArray();
        });

        // Featured courses (6 kursus terpopuler)
        $featuredCourses = Course::where('is_published', true)
            ->with(['instructors', 'category'])
            ->withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(6)
            ->get()
            ->map(function($course, $index) {
                $instructor = $course->instructors->first();
                return [
                    'icon'       => '📚',
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
                        'icon'          => '<i class="fa-solid fa-graduation-cap"></i>',
                        'thumbnail_url' => $course->thumbnail_url,
                        'slug'          => $course->slug,
                        'title'         => $course->title,
                        'category'      => $course->category->name ?? 'General',
                        'instructor'    => $instructor ? $instructor->name . ' · ' . ($instructor->headline ?? 'Instructor') : 'Coursify Team',
                        'rating'        => number_format($course->average_rating ?: 4.8, 1),
                        'students'      => $this->formatNumber($course->enrollments_count),
                        'duration'      => $course->duration_weeks . 'w',
                        'price'         => $course->price == 0 ? 'Free' : 'Rp ' . number_format($course->price, 0, ',', '.'),
                        'badge'         => $course->price == 0 ? 'free' : ($index < 2 ? 'bestseller' : 'new'),
                        'thumb'         => ($index % 6) + 1,
                    ];
                })
                ->toArray();
        });

        // Featured instructors
        $instructors = User::where('role', 'instructor')
            ->withCount(['coursesTaught'])
            ->take(3)
            ->get()
            ->map(function($inst) {
                return [
                    'avatar'   => '👨‍💻',
                    'name'     => $inst->name,
                    'title'    => $inst->headline ?: 'Expert Instructor',
                    'tags'     => ['Teaching', 'Expert', 'Mentor'],
                    'courses'  => (string) $inst->courses_taught_count,
                    'students' => $this->formatNumber(rand(10000, 100000)),
                ];
            })
            ->toArray();
        $instructors = Cache::remember('home_instructors', 3600, function () {
            return User::where('role', 'instructor')
                ->withCount(['coursesTaught'])
                ->take(3)
                ->get()
                ->map(function($inst) {
                    return [
                        'avatar'   => '👨‍🏫',
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