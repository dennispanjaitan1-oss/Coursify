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
                    $sq->withTrashed();
                }])->orderBy('name');
            }])
            ->withCount(['courses' => function ($q) {
                $q->withTrashed();
            }])
            ->orderBy('name')
            ->get();

        // ── Flat list semua kategori (untuk backward compat stats bar) ────────
        $categories = Category::withCount(['courses' => function ($q) {
            $q->withTrashed();
        }])->orderBy('name')->get();
        // ── Ambil semua kategori ─────────────────────────────────
        $categories = Category::withCount([
            'courses' => function ($q) {
                $q->withTrashed();
            }
        ])->orderBy('name')->get();

        // ── Total course ────────────────────────────────────────
        $totalCourses = Course::withTrashed()->count();

        try {

            // ── Query utama ─────────────────────────────────────
            $query = Course::withTrashed()
                ->with([
                    'category',
                    'institution',
                    'instructors'
                ])
                ->withCount('enrollments')
                ->withAvg('reviews', 'rating');

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

            $courses = Course::withTrashed()
                ->where('id', 0)
                ->paginate(12);
        }

        return view('courses.index', compact('courses', 'categories', 'parentCategories', 'totalCourses'));
        return view(
            'courses.index',
            compact(
                'courses',
                'categories',
                'totalCourses'
            )
        );
    }

    public function show($slug)
    {
        try {

            $course = Course::withTrashed()
                ->where('slug', $slug)
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
}