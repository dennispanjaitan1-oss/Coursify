<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // ── INDEX — daftar kursus milik instructor ini ──────────────
    public function index()
    {
        $courses = Course::whereHas('instructors', function ($q) {
                        $q->where('user_id', Auth::id());
                    })
                    ->withCount('enrollments')
                    ->latest()
                    ->paginate(10);

        return view('instructor.courses.index', compact('courses'));
    }

    // ── CREATE — form tambah kursus ─────────────────────────────
    public function create()
    {
        $categories = Category::all();
        return view('instructor.courses.create', compact('categories'));
    }

    // ── STORE — simpan kursus baru ──────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:2000',
'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'difficulty'        => 'required|in:beginner,intermediate,advanced',
            'duration_weeks'    => 'required|integer|min:1',
            'language'          => 'required|string',
            'thumbnail_url'     => 'nullable|url',
            'preview_video_url' => 'nullable|url',
        ]);

        // Auto-generate slug dari title
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        $institutionId = Auth::user()->institution_id ?? Institution::query()->value('id');
        if (! $institutionId) {
            return back()
                ->withInput()
                ->with('error', 'Belum ada institution yang tersedia untuk membuat course.');
        }

        $validated['institution_id'] = $institutionId;
        $validated['is_published']   = $request->input('action') === 'publish';

        $course = Course::create($validated);

        // Attach instructor ke pivot table
        $course->instructors()->attach(Auth::id(), ['role' => 'lead']);

        return redirect()->route('instructor.courses.index')
                         ->with('success', 'Kursus berhasil dibuat!');
    }

    // ── SHOW — detail satu kursus ───────────────────────────────
    public function show(Course $course)
    {
        $this->authorizeInstructor($course);

        $course->load(['category', 'sections.lessons', 'enrollments'])
               ->loadCount(['enrollments', 'reviews'])
               ->loadAvg('reviews', 'rating');
        
        return view('instructor.courses.show', compact('course'));
    }

    // ── EDIT — form edit kursus ─────────────────────────────────
    public function edit(Course $course)
    {
        $this->authorizeInstructor($course);

        $categories = Category::all();
        return view('instructor.courses.edit', compact('course', 'categories'));
    }

    // ── UPDATE — simpan perubahan ───────────────────────────────
    public function update(Request $request, Course $course)
    {
        $this->authorizeInstructor($course);

        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:2000',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'difficulty'        => 'required|in:beginner,intermediate,advanced',
            'duration_weeks'    => 'required|integer|min:1',
            'language'          => 'required|string',
            'thumbnail_url'     => 'nullable|url',
            'preview_video_url' => 'nullable|url',
        ]);

        if ($request->has('action')) {
            $validated['is_published'] = $request->input('action') === 'publish';
        } elseif ($request->has('is_published')) {
            $validated['is_published'] = true;
        } else {
            $validated['is_published'] = $course->is_published;
        }

        $course->update($validated);

        return redirect()->route('instructor.courses.index')
                         ->with('success', 'Kursus berhasil diperbarui!');
    }

    // ── DESTROY — hapus kursus (soft delete) ────────────────────
    public function destroy(Course $course)
    {
        $this->authorizeInstructor($course);

        $course->delete(); // soft delete karena model pakai SoftDeletes

        return redirect()->route('instructor.courses.index')
                         ->with('success', 'Kursus berhasil dihapus!');
    }

    // ── Helper: pastikan hanya instructor pemilik yang bisa akses ─
    private function authorizeInstructor(Course $course)
    {
        $isOwner = $course->instructors()->where('user_id', Auth::id())->exists();
        abort_if(!$isOwner, 403, 'Anda tidak punya akses ke kursus ini.');
    }
}
