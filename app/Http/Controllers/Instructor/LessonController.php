<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /** POST /instructor/sections/{section}/lessons */
    public function store(Request $request, Section $section)
    {
        $this->authorizeInstructor($section);

        $request->validate([
            'title'           => 'required|string|max:255',
            'type'            => 'required|in:video,article,quiz',
            'video_url'       => 'nullable|url|max:500',
            'content'         => 'nullable|string',
            'duration_minutes'=> 'nullable|integer|min:1|max:600',
            'is_free_preview' => 'nullable|boolean',
        ]);

        $maxOrder = $section->lessons()->max('order_index') ?? 0;

        // Convert minutes to seconds for storage
        $durationSeconds = $request->duration_minutes
            ? $request->duration_minutes * 60
            : null;

        $lesson = $section->lessons()->create([
            'title'           => $request->title,
            'type'            => $request->type,
            'video_url'       => $request->video_url,
            'content'         => $request->content,
            'duration_seconds'=> $durationSeconds,
            'is_free_preview' => $request->boolean('is_free_preview', false),
            'order_index'     => $maxOrder + 1,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'lesson'  => [
                    'id'    => $lesson->id,
                    'title' => $lesson->title,
                    'type'  => $lesson->type,
                ],
            ]);
        }

        return back()->with('success', 'Lesson berhasil ditambahkan.');
    }

    /** PUT /instructor/lessons/{lesson} */
    public function update(Request $request, Lesson $lesson)
    {
        $this->authorizeInstructor($lesson->section);

        $request->validate([
            'title'           => 'required|string|max:255',
            'type'            => 'required|in:video,article,quiz',
            'video_url'       => 'nullable|url|max:500',
            'content'         => 'nullable|string',
            'duration_minutes'=> 'nullable|integer|min:1|max:600',
            'is_free_preview' => 'nullable|boolean',
        ]);

        $durationSeconds = $request->duration_minutes
            ? $request->duration_minutes * 60
            : null;

        $lesson->update([
            'title'           => $request->title,
            'type'            => $request->type,
            'video_url'       => $request->video_url,
            'content'         => $request->content,
            'duration_seconds'=> $durationSeconds,
            'is_free_preview' => $request->boolean('is_free_preview', false),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Lesson berhasil diperbarui.');
    }

    /** DELETE /instructor/lessons/{lesson} */
    public function destroy(Lesson $lesson)
    {
        $this->authorizeInstructor($lesson->section);

        $lesson->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Lesson berhasil dihapus.');
    }

    private function authorizeInstructor(Section $section): void
    {
        $isOwner = $section->course->instructors()->where('user_id', Auth::id())->exists();
        abort_if(Auth::user()->role !== 'admin' && !$isOwner, 403, 'Anda tidak memiliki akses ke lesson ini.');
    }
}
