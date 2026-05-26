<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Enrollment;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LearningController extends Controller
{
    public function index(string $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $this->checkEnrollment($course);

        $sections = $course->sections()
            ->with('lessons')
            ->orderBy('order_index')
            ->get();

        $firstLesson = $sections
            ->flatMap->lessons
            ->sortBy('order_index')
            ->first();

        if (!$firstLesson) {
            return redirect()->route('student.courses')
                ->with('warning', 'Course "' . $course->title . '" belum memiliki materi. Silakan cek kembali nanti.');
        }

        return redirect()->route('student.learn.lesson', [
            $course->slug, $firstLesson->id
        ]);
    }

    public function lesson(string $slug, Lesson $lesson)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $this->checkEnrollment($course);

        $enrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)->first();

        $sections = $course->sections()
            ->with(['lessons' => function ($q) {
                $q->orderBy('order_index');
            }])->orderBy('order_index')->get();

        $allLessonIds = $sections->flatMap->lessons->pluck('id');

        $progress = LessonProgress::where('user_id', auth()->id())
            ->whereIn('lesson_id', $allLessonIds)
            ->get()
            ->keyBy('lesson_id');

        $totalLessons    = $allLessonIds->count();
        $completedCount  = $progress->where('is_completed', true)->count();

        // Cari prev/next lesson
        $allLessons  = $sections->flatMap->lessons;
        $currentIdx  = $allLessons->search(fn($l) => $l->id === $lesson->id);
        $prevLesson  = $currentIdx > 0 ? $allLessons->get($currentIdx - 1) : null;
        $nextLesson  = $allLessons->get($currentIdx + 1);

        $isAudit = $enrollment->isAudit();
        $isAuditExpired = $isAudit && $course->isAuditAccessExpired($enrollment->created_at);

        return view('student.learn', compact(
            'course', 'lesson', 'sections', 'progress',
            'enrollment', 'totalLessons', 'completedCount',
            'prevLesson', 'nextLesson', 'isAudit', 'isAuditExpired'
        ));
    }

    public function updateProgress(Request $request, Lesson $lesson)
    {
        $request->validate(['is_completed' => 'required|boolean']);

        LessonProgress::updateOrCreate(
            ['user_id' => auth()->id(), 'lesson_id' => $lesson->id],
            [
                'is_completed'          => $request->is_completed,
                'last_position_seconds' => $request->position ?? 0,
            ]
        );

        $course = $lesson->section->course;

        // Eager load sections + lessons sekali saja (hindari N+1 dan bug lazy-load tanpa lessons)
        $sections     = $course->sections()->with('lessons')->get();
        $allLessonIds = $sections->flatMap->lessons->pluck('id');
        $totalLessons = $allLessonIds->count();

        $doneLessons = LessonProgress::where('user_id', auth()->id())
            ->whereIn('lesson_id', $allLessonIds)
            ->where('is_completed', true)
            ->count();

        $percent = $totalLessons > 0 ? round(($doneLessons / $totalLessons) * 100, 2) : 0;

        $enrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)->first();

        if ($enrollment?->isAudit() && $course->isAuditAccessExpired($enrollment->created_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Akses audit kamu sudah berakhir. Upgrade ke Verified untuk melanjutkan.',
            ], 403);
        }

        $certificateEarned = false;

        if ($enrollment) {
            $enrollment->update([
                'progress_percent' => $percent,
                'status'           => $percent >= 100 ? 'completed' : 'active',
                'completed_at'     => $percent >= 100 ? now() : null,
            ]);

            // Buat sertifikat jika kursus selesai dan track adalah verified/honor
            if ($percent >= 100 && in_array($enrollment->type, ['verified', 'honor'])) {
                $alreadyHasCert = Certificate::where('user_id', auth()->id())
                    ->where('course_id', $course->id)
                    ->exists();

                if (!$alreadyHasCert) {
                    Certificate::create([
                        'user_id'            => auth()->id(),
                        'course_id'          => $course->id,
                        'enrollment_id'      => $enrollment->id,
                        'certificate_type'   => $enrollment->type,
                        'certificate_number' => 'CERT-' . date('Y') . '-' . strtoupper(Str::random(8)),
                        'issued_at'          => now(),
                    ]);
                    $certificateEarned = true;
                }
            }
        }

        return response()->json([
            'progress'          => $percent,
            'success'           => true,
            'certificate_earned' => $certificateEarned,
        ]);
    }

    private function checkEnrollment(Course $course): void
    {
        $isEnrolled = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->exists();

        if (!$isEnrolled) {
            abort(403, 'Kamu belum terdaftar di kursus ini.');
        }
    }
}
