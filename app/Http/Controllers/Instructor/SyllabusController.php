<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSyllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SyllabusController extends Controller
{
    /** POST /instructor/courses/{course}/syllabus */
    public function store(Request $request, Course $course)
    {
        $this->authorizeInstructor($course);

        $request->validate([
            'item' => 'required|string|max:500',
        ]);

        $maxOrder = $course->syllabus()->max('order_index') ?? 0;

        $item = $course->syllabus()->create([
            'item'        => $request->item,
            'order_index' => $maxOrder + 1,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'item'    => ['id' => $item->id, 'item' => $item->item],
            ]);
        }

        return back()->with('success', 'Item syllabus berhasil ditambahkan.');
    }

    /** PUT /instructor/syllabus/{syllabus} */
    public function update(Request $request, CourseSyllabus $syllabus)
    {
        $this->authorizeInstructor($syllabus->course);

        $request->validate([
            'item' => 'required|string|max:500',
        ]);

        $syllabus->update(['item' => $request->item]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Item syllabus berhasil diperbarui.');
    }

    /** DELETE /instructor/syllabus/{syllabus} */
    public function destroy(CourseSyllabus $syllabus)
    {
        $this->authorizeInstructor($syllabus->course);

        $syllabus->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Item syllabus berhasil dihapus.');
    }

    private function authorizeInstructor(Course $course): void
    {
        $isOwner = $course->instructors()->where('user_id', Auth::id())->exists();
        abort_if(Auth::user()->role !== 'admin' && !$isOwner, 403, 'Anda tidak memiliki akses ke kursus ini.');
    }
}
