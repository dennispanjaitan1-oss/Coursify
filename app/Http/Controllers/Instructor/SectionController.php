<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /** POST /instructor/courses/{course}/sections */
    public function store(Request $request, Course $course)
    {
        $this->authorizeInstructor($course);

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $maxOrder = $course->sections()->max('order_index') ?? 0;

        $section = $course->sections()->create([
            'title'       => $request->title,
            'order_index' => $maxOrder + 1,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'section' => ['id' => $section->id, 'title' => $section->title],
            ]);
        }

        return back()->with('success', 'Section berhasil ditambahkan.');
    }

    /** PUT /instructor/sections/{section} */
    public function update(Request $request, Section $section)
    {
        $this->authorizeInstructor($section->course);

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $section->update(['title' => $request->title]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Section berhasil diperbarui.');
    }

    /** DELETE /instructor/sections/{section} */
    public function destroy(Section $section)
    {
        $this->authorizeInstructor($section->course);

        $section->delete(); // Cascades to lessons & quizzes via FK

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Section berhasil dihapus.');
    }

    private function authorizeInstructor(Course $course): void
    {
        $isOwner = $course->instructors()->where('user_id', Auth::id())->exists();
        abort_if(Auth::user()->role !== 'admin' && !$isOwner, 403, 'Anda tidak memiliki akses ke kursus ini.');
    }
}
