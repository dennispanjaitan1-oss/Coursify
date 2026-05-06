<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = null;

        try {
            $query = Course::where('is_published', true)
                ->with(['category', 'instructors']);

            // Search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('short_description', 'LIKE', "%{$search}%");
                });
            }

            // Category filter
            if ($request->filled('category')) {
                $query->whereHas('category', function($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }

            // Difficulty filter
            if ($request->filled('difficulty')) {
                $query->where('difficulty', $request->difficulty);
            }

            // Price filter
            if ($request->filled('price')) {
                if ($request->price === 'free') {
                    $query->where('price', 0);
                } elseif ($request->price === 'paid') {
                    $query->where('price', '>', 0);
                }
            }

            // Sort
            switch ($request->get('sort')) {
                case 'newest':
                    $query->latest();
                    break;
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->withCount('enrollments')->orderBy('enrollments_count', 'desc');
            }

            $courses = $query->paginate(12);
        } catch (\Exception $e) {
            $courses = null;
        }

        return view('courses.index', compact('courses'));
    }

    public function show($slug)
{
    $course = null;
    try {
        $course = \App\Models\Course::where('slug', $slug)
            ->where('is_published', true)
            ->with(['category', 'institution', 'instructors', 'sections.lessons'])
            ->firstOrFail();
    } catch (\Exception $e) {
        // Allow default dummy data di blade
    }

    return view('courses.show', compact('course'));
}
}