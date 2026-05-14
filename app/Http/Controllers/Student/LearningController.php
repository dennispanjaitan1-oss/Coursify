<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    public function index(string $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $this->checkEnrollment($course);

        $sections    = $course->sections()->with('lessons')->orderBy('order_index')->get();
        $firstLesson = $sections->first()?->lessons->first();

        return redirect()->route('student.learn.lesson', [
            $course->slug, $firstLesson?->id
        ]);
    }

    public function lesson(string $slug, Lesson $lesson)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $this->checkEnrollment($course);

        $enrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)->first();

        $sections = $course->sections()
            ->with(['lessons' => function($q) {
                $q->orderBy('order_index');
            }])->orderBy('order_index')->get();

        $progress = LessonProgress::where('user_id', auth()->id())
            ->whereIn('lesson_id', $sections->flatMap->lessons->pluck('id'))
            ->get()
            ->keyBy('lesson_id');

        return view('student.learn', compact('course', 'lesson', 'sections', 'progress', 'enrollment'));
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

        $course       = $lesson->section->course;
        $totalLessons = $course->sections()->with('lessons')->get()
            ->flatMap->lessons->count();
        $doneLessons  = LessonProgress::where('user_id', auth()->id())
            ->whereIn('lesson_id', $course->sections->flatMap->lessons->pluck('id'))
            ->where('is_completed', true)
            ->count();

        $percent = $totalLessons > 0 ? round(($doneLessons / $totalLessons) * 100, 2) : 0;

        $enrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)->first();

        if ($enrollment) {
            $enrollment->update([
                'progress_percent' => $percent,
                'status'           => $percent >= 100 ? 'completed' : 'active',
                'completed_at'     => $percent >= 100 ? now() : null,
            ]);

            if ($percent >= 100 && !$course->certificates()->where('user_id', auth()->id())->exists()) {
                \App\Models\Certificate::create([
                    'user_id'            => auth()->id(),
                    'course_id'          => $course->id,
                    'certificate_number' => 'CERT-' . date('Y') . '-' . strtoupper(\Illuminate\Support\Str::random(8)),
                    'issued_at'          => now(),
                ]);
            }
        }

        return response()->json(['progress' => $percent, 'success' => true]);
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