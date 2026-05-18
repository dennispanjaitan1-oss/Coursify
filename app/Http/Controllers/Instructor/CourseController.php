<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // ── INDEX — daftar kursus milik instructor ini ──────────────
    public function index()
    {
        $instructor = Auth::user();
        $courseIds = $instructor->coursesTaught()->pluck('courses.id');
        if ($courseIds->isEmpty()) {
            $demoCourses = Course::take(5)->pluck('id');
            if ($demoCourses->isNotEmpty()) {
                $instructor->coursesTaught()->syncWithoutDetaching($demoCourses);
            }
        }

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
    public function store(StoreCourseRequest $request)
    {
        $validated = $request->validated();

        // Auto-generate slug dari title jika tidak diisi manual
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        $validated['institution_id'] = Auth::user()->institution_id ?? 1;
        $validated['is_published']   = $request->boolean('is_published');

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

        $course->load(['category', 'sections.lessons', 'enrollments']);
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
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorizeInstructor($course);

        $validated = $request->validated();
        $validated['is_published'] = $request->boolean('is_published');

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