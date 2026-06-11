<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        // ── Ambil parent categories dengan children (untuk accordion sidebar) ─
        $parentCategories = Category::whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->withCount(['courses' => function ($sq) {
                    $sq->where('is_published', true);
                }])->orderBy('name');
            }])
            ->withCount(['courses' => function ($q) {
                $q->where('is_published', true);
            }])
            ->orderBy('name')
            ->get();

        $categories = Category::withCount(['courses' => function ($q) {
            $q->where('is_published', true);
        }])->orderBy('name')->get();

        // ── Total course ────────────────────────────────────────
        $totalCourses = Course::where('is_published', true)->count();

        try {

            // ── Query utama ─────────────────────────────────────
            $query = Course::with([
                    'category',
                    'institution',
                    'instructors'
                ])
                ->withCount('enrollments')
                ->withAvg('reviews', 'rating')
                ->where('is_published', true);

            // ── SEARCH ──────────────────────────────────────────
            if ($request->filled('search')) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('short_description', 'LIKE', "%{$search}%");
                });
            }

            // ── CATEGORY FILTER ─────────────────────────────────
            $categoryFilter = array_filter(
                (array) $request->input('category', [])
            );

            if (!empty($categoryFilter)) {

                $query->whereHas('category', function ($q) use ($categoryFilter) {
                    $q->whereIn('slug', $categoryFilter);
                });
            }

            // ── DIFFICULTY FILTER ───────────────────────────────
            $difficultyFilter = array_filter(
                (array) $request->input('difficulty', [])
            );

            if (!empty($difficultyFilter)) {
                $query->whereIn('difficulty', $difficultyFilter);
            }

            // ── PRICE FILTER ────────────────────────────────────
            $priceFilter = array_filter(
                (array) $request->input('price', [])
            );

            if (!empty($priceFilter)) {

                $query->where(function ($q) use ($priceFilter) {

                    if (in_array('free', $priceFilter)) {
                        $q->orWhere('price', 0);
                    }

                    if (in_array('paid', $priceFilter)) {
                        $q->orWhere('price', '>', 0);
                    }
                });
            }

            // ── MAX PRICE ───────────────────────────────────────
            if (
                $request->filled('max_price') &&
                (int) $request->max_price < 500000
            ) {

                $query->where(function ($q) use ($request) {

                    $q->where('price', 0)
                      ->orWhere('price', '<=', (int) $request->max_price);
                });
            }

            // ── RATING FILTER (FIXED) ───────────────────────────
            if ($request->filled('rating')) {

                $minRating = (int) $request->rating;

                $query->having(
                    'reviews_avg_rating',
                    '>=',
                    $minRating
                );
            }

            // ── LANGUAGE FILTER ─────────────────────────────────
            $languageFilter = array_filter(
                (array) $request->input('language', [])
            );

            if (!empty($languageFilter)) {
                $query->whereIn('language', $languageFilter);
            }

            // ── SORTING ─────────────────────────────────────────
            switch ($request->get('sort', 'popular')) {

                case 'newest':
                    $query->latest('created_at');
                    break;

                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;

                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;

                case 'rating':
                    $query->orderBy('reviews_avg_rating', 'desc');
                    break;

                case 'popular':
                default:
                    $query->orderBy('enrollments_count', 'desc');
                    break;
            }

            // ── PAGINATION ──────────────────────────────────────
            $courses = $query->paginate(12)
                ->withQueryString();

        } catch (\Exception $e) {

            Log::error(
                'CourseController@index error: ' . $e->getMessage()
            );

            $courses = Course::where('id', 0)
                ->where('is_published', true)
                ->paginate(12);
        }

        // ── JSON for autocomplete (AJAX / XMLHttpRequest) ──────────────
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($courses->map(fn($c) => [
                'id'        => $c->id,
                'title'     => $c->title,
                'slug'      => $c->slug,
                'category'  => $c->category?->name,
                'thumbnail' => $c->thumbnail ? asset('storage/' . $c->thumbnail) : null,
            ]));
        }

        return view('courses.index', compact('courses', 'categories', 'parentCategories', 'totalCourses'));
    }

    public function show($slug)
    {
        try {

            $course = Course::where('slug', $slug)
                ->where('is_published', true)
                ->with([
                    'category',
                    'institution',
                    'instructors',
                    'sections.lessons',
                    'reviews.user',
                    'syllabus',
                ])
                ->withCount('enrollments')
                ->withAvg('reviews', 'rating')
                ->firstOrFail();

            return view('courses.show', compact('course'));

        } catch (\Exception $e) {

            Log::error(
                'CourseController@show error: ' . $e->getMessage()
            );

            abort(404);
        }
    }

    public function choosePath(Course $course)
    {
        $course->load(['institution'])->loadCount('enrollments');

        $alreadyEnrolled = auth()->user()
            ->enrollments()
            ->where('course_id', $course->id)
            ->first();

        // Sudah enrolled sebagai verified/honor → langsung ke course
        if ($alreadyEnrolled && in_array($alreadyEnrolled->type, ['verified', 'honor'])) {
            return redirect()->route('student.learn', $course->slug)
                ->with('info', 'Kamu sudah berada di jalur Verified.');
        }

        return view('courses.choose-path', compact('course', 'alreadyEnrolled'));
    }
}
