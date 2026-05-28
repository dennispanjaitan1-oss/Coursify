<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Institution;
use App\Models\Program;
use App\Models\User;
use App\Models\CourseSyllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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

        // Categories dengan course count
        Cache::forget('home_categories');
        $categories = Cache::remember('home_categories', 3600, function () {
            return Category::whereNull('parent_id')
                ->whereNotIn('slug', ['art', 'business-administration', 'uncategorized'])
                ->whereHas('courses', function ($q) {
                    $q->where('is_published', true);
                })
                ->withCount(['courses' => function($q) {
                    $q->where('is_published', true);
                }])
                ->orderByDesc('courses_count')
                ->take(6)
                ->get()
                ->map(function($cat) {
                $iconMap = [
                    'Architecture'            => 'fa-solid fa-building-columns',
                    'Art'                     => 'fa-solid fa-palette',
                    'Biology'                 => 'fa-solid fa-dna',
                    'Business Administration' => 'fa-solid fa-briefcase',
                    'Chemistry'               => 'fa-solid fa-flask',
                    'Computer Programming'    => 'fa-solid fa-code',
                    'Data Analysis'           => 'fa-solid fa-chart-bar',
                    'Economics'               => 'fa-solid fa-chart-line',
                    'Engineering'             => 'fa-solid fa-gears',
                    'Mathematics'             => 'fa-solid fa-square-root-variable',
                    'Music'                   => 'fa-solid fa-music',
                    'Physics'                 => 'fa-solid fa-atom',
                    'Design'                  => 'fa-solid fa-pen-nib',
                    'Marketing'               => 'fa-solid fa-bullhorn',
                    'Language'                => 'fa-solid fa-language',
                    'History'                 => 'fa-solid fa-landmark',
                    'Psychology'              => 'fa-solid fa-brain',
                    'Health'                  => 'fa-solid fa-heart-pulse',
                    'Finance'                 => 'fa-solid fa-coins',
                    'Law'                     => 'fa-solid fa-scale-balanced',
                    'General'                 => 'fa-solid fa-book-open',
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

        // Featured courses (6 kursus terpopuler)SELECT courses.*,
        //        COUNT(DISTINCT enrollments.id) AS enrollments_count
        // FROM courses
        // LEFT JOIN enrollments ON enrollments.course_id = courses.id
        // WHERE courses.is_published = 1
        // GROUP BY courses.id
        // ORDER BY enrollments_count DESC
        // LIMIT 6;

        $featuredCourses = Cache::remember('home_featured_courses', 3600, function () {
            return Course::where('is_published', true)
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

        // Promo banner courses (6 latest published courses)
        $promoCourses = Cache::remember('home_promo_courses', 3600, function () {
            return Course::where('is_published', true)
                ->with(['instructors', 'category'])
                ->withCount('enrollments')
                ->withAvg('reviews', 'rating')
                ->latest()
                ->take(6)
                ->get()
                ->map(function($course) {
                    $instructor = $course->instructors->first();
                    return [
                        'slug'          => $course->slug,
                        'title'         => $course->title,
                        'thumbnail_url' => $course->thumbnail_url,
                        'category'      => $course->category->name ?? 'General',
                        'instructor'    => $instructor ? $instructor->name . ' · ' . ($instructor->headline ?? 'Instructor') : 'Coursify Team',
                        'rating'        => number_format($course->reviews_avg_rating ?: 4.8, 1),
                        'students'      => $this->formatNumber($course->enrollments_count),
                        'duration'      => $course->duration_weeks . 'w',
                        'price'         => $course->price == 0 ? 'Free' : 'Rp ' . number_format($course->price, 0, ',', '.'),
                        'is_free'       => $course->price == 0,
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
                        'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($inst->name) . '&background=1E3A5F&color=fff&size=150&bold=true',
                        'name'     => $inst->name,
                        'title'    => $inst->headline ?: 'Expert Instructor',
                        'tags'     => ['Teaching', 'Expert', 'Mentor'],
                        'courses'  => (string) $inst->courses_taught_count,
                        'students' => $this->formatNumber(rand(10000, 100000)),
                    ];
                })
                ->toArray();
        });

        // Partner institutions untuk marquee di hero
        $partnerInstitutions = Cache::remember('home_partner_institutions', 3600, function () {
            return Institution::whereNotNull('logo_url')
                ->where('logo_url', '!=', '')
                ->withCount(['courses' => function ($q) {
                    $q->where('is_published', true);
                }])
                ->orderByDesc('courses_count')
                ->take(12)
                ->get()
                ->map(function (Institution $inst) {
                    return [
                        'name'     => $inst->name,
                        'slug'     => $inst->slug,
                        'logo_url' => $inst->logo_url,
                    ];
                })
                ->toArray();
        });

        // Fallback jika DB kosong — pakai logo lokal yang sudah ada
        if (empty($partnerInstitutions)) {
            $partnerInstitutions = [
                ['name' => 'Universitas Indonesia',         'slug' => 'universitas-indonesia',          'logo_url' => asset('images/universities/ui-logo.png')],
                ['name' => 'Institut Teknologi Bandung',    'slug' => 'institut-teknologi-bandung',     'logo_url' => asset('images/universities/itb-logo.png')],
                ['name' => 'Universitas Gadjah Mada',       'slug' => 'universitas-gadjah-mada',        'logo_url' => asset('images/universities/ugm-logo.png')],
                ['name' => 'Institut Teknologi Sepuluh Nopember', 'slug' => 'its',                      'logo_url' => asset('images/universities/its-logo.png')],
                ['name' => 'Universitas Brawijaya',         'slug' => 'universitas-brawijaya',          'logo_url' => asset('images/universities/ub-logo.png')],
                ['name' => 'Universitas Diponegoro',        'slug' => 'universitas-diponegoro',         'logo_url' => asset('images/universities/undip-logo.png')],
                ['name' => 'Universitas Airlangga',         'slug' => 'universitas-airlangga',          'logo_url' => asset('images/universities/unair-logo.png')],
                ['name' => 'BINUS University',              'slug' => 'binus-university',               'logo_url' => asset('images/universities/binus-logo.png')],
                ['name' => 'Institut Pertanian Bogor',      'slug' => 'institut-pertanian-bogor',       'logo_url' => asset('images/universities/ipb-logo.png')],
            ];
        }

        // Featured programs (3 latest published programs)
        $featuredPrograms = Cache::remember('home_featured_programs', 3600, function () {
            return Program::where('is_published', true)
                ->with(['institution', 'courses'])
                ->latest()
                ->take(3)
                ->get()
                ->map(function($prog) {
                    $types = [
                        'professional_certificate' => 'Professional Certificate',
                        'micromasters' => 'MicroMasters',
                        'microbachelors' => 'MicroBachelors',
                        'degree' => 'Degree',
                        'executive_education' => 'Executive Education',
                    ];
                    return [
                        'title' => $prog->title,
                        'slug' => $prog->slug,
                        'type' => $types[$prog->type] ?? ucwords(str_replace('_', ' ', $prog->type)),
                        'description' => $prog->description,
                        'thumbnail_url' => $prog->thumbnail_url ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=60',
                        'institution_name' => $prog->institution->name ?? 'Partner Institution',
                        'institution_logo' => $prog->institution->logo_url,
                        'courses_count' => $prog->courses->count(),
                    ];
                })
                ->toArray();
        });

        // Latest courses for "The latest on Coursify" slider
        $latestCourses = Cache::remember('home_latest_courses', 3600, function () {
            return Course::where('is_published', true)
                ->with(['institution'])
                ->latest('created_at')
                ->take(8)
                ->get()
                ->map(function($course) {
                    return [
                        'slug'          => $course->slug,
                        'title'         => $course->title,
                        'thumbnail_url' => $course->thumbnail_url,
                        'institution'   => $course->institution->name ?? 'Coursify Partner',
                        'institution_logo' => $course->institution->logo_url ?? null,
                        'duration'      => $course->duration_weeks ? $course->duration_weeks . ' weeks to complete' : 'Self-paced',
                        'level'         => ucfirst($course->difficulty ?? 'beginner') . ' level',
                    ];
                })
                ->toArray();
        });

        // Subject = semua kategori yang punya kursus
        $subjects = Category::whereHas('courses', function($q) {
            $q->where('is_published', true);
        })->orderBy('name')->get(['id', 'name', 'slug']);

        // Skills = distinct syllabus items dari DB
        $skills = CourseSyllabus::whereHas('course', function($q) {
            $q->where('is_published', true);
        })
        ->select('item')
        ->distinct()
        ->orderBy('item')
        ->pluck('item');

        return view('home.index', compact(
            'stats',
            'studentCount',
            'categories',
            'featuredCourses',
            'promoCourses',
            'instructors',
            'partnerInstitutions',
            'featuredPrograms',
            'latestCourses',
            'subjects',
            'skills'
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