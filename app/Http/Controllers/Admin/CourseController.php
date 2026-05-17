<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\Institution;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Tampilkan daftar semua course.
     */
    public function index(Request $request)
    {
        $query = Course::with(['category', 'institution', 'program'])
                       ->withCount(['enrollments', 'sections']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $courses      = $query->latest()->paginate(10)->withQueryString();
        $categories   = Category::orderBy('name')->get();
        $institutions = Institution::orderBy('name')->get();
        $programs     = Program::orderBy('title')->get();

        return view('admin.courses', compact('courses', 'categories', 'institutions', 'programs'));
    }

    /**
     * Simpan course baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'institution_id'    => 'required|exists:institutions,id',
            'program_id'        => 'nullable|exists:programs,id',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'duration_weeks'    => 'required|integer|min:1',
            'difficulty'        => 'required|in:beginner,intermediate,advanced',
            'language'          => 'required|string|max:10',
            'thumbnail_url'     => 'nullable|url|max:500',
            'preview_video_url' => 'nullable|url|max:500',
            'is_published'      => 'boolean',
            'order_index'       => 'integer|min:0',
        ]);

        $validated['slug']         = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['order_index']  = $request->input('order_index', 0);

        Course::create($validated);

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course berhasil ditambahkan!');
    }

    /**
     * Update course yang sudah ada.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'institution_id'    => 'required|exists:institutions,id',
            'program_id'        => 'nullable|exists:programs,id',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'duration_weeks'    => 'required|integer|min:1',
            'difficulty'        => 'required|in:beginner,intermediate,advanced',
            'language'          => 'required|string|max:10',
            'thumbnail_url'     => 'nullable|url|max:500',
            'preview_video_url' => 'nullable|url|max:500',
            'is_published'      => 'boolean',
            'order_index'       => 'integer|min:0',
        ]);

        if ($validated['title'] !== $course->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['order_index']  = $request->input('order_index', $course->order_index);

        $course->update($validated);

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course berhasil diperbarui!');
    }

    /**
     * Toggle status published course.
     */
    public function togglePublish(Course $course)
    {
        $course->update(['is_published' => !$course->is_published]);
        $status = $course->is_published ? 'dipublikasikan' : 'disembunyikan';

        return redirect()->route('admin.courses.index')
                         ->with('success', "Course berhasil {$status}!");
    }

    /**
     * Hapus course (soft delete).
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course berhasil dihapus!');
    }
}