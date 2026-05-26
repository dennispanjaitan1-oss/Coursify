<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Category;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * List semua program yang dipublikasikan, dengan filter opsional.
     */
    public function index(Request $request)
    {
        $query = Program::with(['institution', 'category', 'courses'])
            ->published()
            ->orderBy('title');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Search
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(fn($q) =>
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
            );
        }

        $programs  = $query->paginate(12)->withQueryString();
        $categories = Category::whereNull('parent_id')->orderBy('name')->get();

        // Stats untuk halaman
        $totalPrograms  = Program::published()->count();
        $programTypes   = Program::published()
            ->selectRaw('type, count(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        return view('programs.index', compact('programs', 'categories', 'totalPrograms', 'programTypes'));
    }

    /**
     * Detail satu program beserta course-nya.
     */
    public function show(string $slug)
    {
        $program = Program::with([
            'institution',
            'category',
            'courses' => fn($q) => $q->published()->with(['institution', 'instructors'])->orderBy('order_index'),
        ])
        ->where('slug', $slug)
        ->published()
        ->firstOrFail();

        // Statistik program
        $totalCourses   = $program->courses->count();
        $totalWeeks     = $program->courses->sum('duration_weeks');
        $avgRating      = $program->courses->avg(fn($c) => $c->reviews()->avg('rating') ?? 0);
        $totalStudents  = $program->courses
            ->flatMap(fn($c) => $c->enrollments)
            ->unique('user_id')
            ->count();

        // Program lain dalam kategori yang sama (rekomendasi)
        $relatedPrograms = Program::with(['institution', 'category'])
            ->published()
            ->where('id', '!=', $program->id)
            ->where('category_id', $program->category_id)
            ->take(3)
            ->get();

        return view('programs.show', compact(
            'program', 'totalCourses', 'totalWeeks',
            'avgRating', 'totalStudents', 'relatedPrograms'
        ));
    }
}
