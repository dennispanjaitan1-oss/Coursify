<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LessonProgressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ── INDEX — progress semua lesson untuk satu course ──────────
    /**
     * GET /dashboard/learn/{slug}/progress
     * Kembalikan progress seluruh lesson dalam course (JSON).
     */
    public function index(Course $course): JsonResponse
    {
        $user = Auth::user();

        // Pastikan user sudah enroll
        $enrollment = Enrollment::where('user_id', $user->id)
                                ->where('course_id', $course->id)
                                ->first();

        if (!$enrollment) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu belum terdaftar di kursus ini.',
            ], 403);
        }

        // Ambil semua lesson ID di course ini
        $lessonIds = $course->lessons()->pluck('lessons.id');

        // Ambil progress user untuk lesson tersebut
        $progress = LessonProgress::where('user_id', $user->id)
                                  ->whereIn('lesson_id', $lessonIds)
                                  ->get()
                                  ->keyBy('lesson_id');

        return response()->json([
            'success'          => true,
            'enrollment_id'    => $enrollment->id,
            'progress_percent' => $enrollment->progress_percent,
            'status'           => $enrollment->status,
            'lessons'          => $progress->map(fn($p) => [
                'lesson_id'             => $p->lesson_id,
                'is_completed'          => $p->is_completed,
                'last_position_seconds' => $p->last_position_seconds,
                'updated_at'            => $p->updated_at?->toISOString(),
            ]),
        ]);
    }

    // ── STORE — tandai lesson sebagai selesai / update posisi ───
    /**
     * POST /dashboard/progress/{lesson}
     * Body: { is_completed: bool, last_position_seconds: int }
     */
    public function store(Request $request, Lesson $lesson): JsonResponse
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'is_completed'          => ['required', 'boolean'],
            'last_position_seconds' => ['nullable', 'integer', 'min:0'],
        ]);

        // Pastikan user sudah enroll ke course yang berisi lesson ini
        $course     = $lesson->section?->course;
        $enrollment = null;

        if ($course) {
            $enrollment = Enrollment::where('user_id', $user->id)
                                    ->where('course_id', $course->id)
                                    ->first();
        }

        if (!$enrollment) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu belum terdaftar di kursus yang berisi lesson ini.',
            ], 403);
        }

        // Update atau buat progress
        $progress = LessonProgress::updateOrCreate(
            [
                'user_id'   => $user->id,
                'lesson_id' => $lesson->id,
            ],
            [
                'is_completed'          => $validated['is_completed'],
                'last_position_seconds' => $validated['last_position_seconds'] ?? 0,
            ]
        );

        // Hitung ulang progress_percent enrollment
        $totalLessons    = $course->lessons()->count();
        $completedCount  = LessonProgress::where('user_id', $user->id)
                                         ->whereIn('lesson_id', $course->lessons()->pluck('lessons.id'))
                                         ->where('is_completed', true)
                                         ->count();

        $progressPercent = $totalLessons > 0
            ? round(($completedCount / $totalLessons) * 100, 2)
            : 0;

        $isNowCompleted = $progressPercent >= 100;

        $enrollment->update([
            'progress_percent' => $progressPercent,
            'status'           => $isNowCompleted ? 'completed' : 'active',
            'completed_at'     => $isNowCompleted && !$enrollment->completed_at ? now() : $enrollment->completed_at,
        ]);

        return response()->json([
            'success'          => true,
            'is_completed'     => $progress->is_completed,
            'progress_percent' => $progressPercent,
            'enrollment_status'=> $enrollment->status,
            'course_completed' => $isNowCompleted,
        ]);
    }

    // ── SHOW — detail progress satu lesson ──────────────────────
    /**
     * GET /dashboard/progress/{lesson}
     */
    public function show(Lesson $lesson): JsonResponse
    {
        $user = Auth::user();

        $progress = LessonProgress::where('user_id', $user->id)
                                  ->where('lesson_id', $lesson->id)
                                  ->first();

        return response()->json([
            'success'  => true,
            'lesson_id'=> $lesson->id,
            'progress' => $progress ? [
                'is_completed'          => $progress->is_completed,
                'last_position_seconds' => $progress->last_position_seconds,
                'updated_at'            => $progress->updated_at?->toISOString(),
            ] : null,
        ]);
    }
}
