<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        // ── Ambil semua kategori (untuk sidebar filter + stats bar) ──────────
        $categories = Category::withCount(['courses' => function ($q) {
            $q->where('is_published', true);
        }])->orderBy('name')->get();

        // ── Total course untuk stats bar ─────────────────────────────────────
        $totalCourses = Course::where('is_published', true)->count();

        // ── Build query utama ─────────────────────────────────────────────────
        $courses = null;

        try {
            $query = Course::where('is_published', true)
                ->with(['category', 'institution', 'instructors'])
                ->withCount('enrollments')
                ->withAvg('reviews', 'rating');

            // ── SEARCH ──────────────────────────────────────────────────────
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('short_description', 'LIKE', "%{$search}%");
                });
            }

            // ── CATEGORY (array: ?category[]=programming&category[]=design) ──
            // Blade mengirim: name="category[]"
            $categoryFilter = array_filter((array) $request->input('category', []));
            if (!empty($categoryFilter)) {
                $query->whereHas('category', function ($q) use ($categoryFilter) {
                    $q->whereIn('slug', $categoryFilter);
                });
            }

            // ── DIFFICULTY (array: ?difficulty[]=beginner&difficulty[]=advanced)
            // Blade mengirim: name="difficulty[]"
            $difficultyFilter = array_filter((array) $request->input('difficulty', []));
            if (!empty($difficultyFilter)) {
                $query->whereIn('difficulty', $difficultyFilter);
            }

            // ── PRICE (array: ?price[]=free&price[]=paid) ────────────────────
            // Blade mengirim: name="price[]"
            $priceFilter = array_filter((array) $request->input('price', []));
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

            // ── MAX PRICE (slider: ?max_price=200000) ────────────────────────
            // Hanya aktif kalau nilainya < 500000 (batas atas slider)
            if ($request->filled('max_price') && (int) $request->max_price < 500000) {
                $query->where(function ($q) use ($request) {
                    // Kursus gratis selalu lolos, atau harganya ≤ max_price
                    $q->where('price', 0)
                      ->orWhere('price', '<=', (int) $request->max_price);
                });
            }

            // ── RATING (radio: ?rating=4) ─────────────────────────────────────
            if ($request->filled('rating')) {
                $minRating = (int) $request->rating;
                // Hanya tampilkan kursus yang rata-rata rating ≥ pilihan
                $query->whereHas('reviews', function ($q) use ($minRating) {
                    $q->havingRaw('AVG(rating) >= ?', [$minRating]);
                });
                // Alternatif lebih akurat (subquery):
                // $query->withAvg sudah di-attach di atas;
                // bisa juga pakai HAVING setelah groupBy jika perlu.
            }

            // ── LANGUAGE (array: ?language[]=id&language[]=en) ───────────────
            // Asumsi Course model punya kolom 'language'
            $languageFilter = array_filter((array) $request->input('language', []));
            if (!empty($languageFilter)) {
                $query->whereIn('language', $languageFilter);
            }

            // ── SORT ─────────────────────────────────────────────────────────
            switch ($request->get('sort', 'popular')) {
                case 'newest':
                    $query->latest();
                    break;
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'rating':
                    // ORDER BY rata-rata rating (kolom alias dari withAvg)
                    $query->orderBy('reviews_avg_rating', 'desc');
                    break;
                case 'popular':
                default:
                    $query->orderBy('enrollments_count', 'desc');
                    break;
            }

            $courses = $query->paginate(12)->withQueryString();
            // withQueryString() → URL pagination menyertakan semua filter aktif

        } catch (\Exception $e) {
            // Log error untuk debugging; blade akan tampilkan empty state
            \Log::error('CourseController@index error: ' . $e->getMessage());
            $courses = Course::where('id', 0)->paginate(12); // empty paginator
        }

        return view('courses.index', compact('courses', 'categories', 'totalCourses'));
    }

    public function show($slug)
    {
        $course = null;
        try {
            $course = Course::where('slug', $slug)
                ->where('is_published', true)
                ->with([
                    'category',
                    'institution',
                    'instructors',
                    'sections.lessons',
                    'reviews.user',      // untuk menampilkan review di halaman show
                ])
                ->withCount('enrollments')
                ->withAvg('reviews', 'rating')
                ->firstOrFail();
        } catch (\Exception $e) {
            // Biarkan $course = null → blade tampilkan dummy/fallback data
        }

        return view('courses.show', compact('course'));
    }
}