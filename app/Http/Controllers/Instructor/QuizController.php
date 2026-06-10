<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizOption;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /** GET /instructor/quizzes — daftar semua lesson quiz milik instructor */
    public function index()
    {
        $instructor = Auth::user();

        $quizzes = Lesson::where('type', 'quiz')
            ->whereHas('section.course.instructors', function ($query) use ($instructor) {
                $query->where('user_id', $instructor->id);
            })
            ->with(['section.course', 'quizzes'])
            ->orderByDesc('created_at')
            ->get();

        return view('instructor.quizzes.index', compact('quizzes'));
    }

    /** GET /instructor/courses/{course}/lessons/{lesson}/quiz/edit */
    public function edit(Lesson $lesson)
    {
        $this->authorizeInstructorLesson($lesson);

        $lesson->load(['section.course', 'quizzes.options']);

        return view('instructor.quizzes.edit', compact('lesson'));
    }

    /** PUT /instructor/lessons/{lesson}/quiz */
    public function update(Request $request, Lesson $lesson)
    {
        $this->authorizeInstructorLesson($lesson);

        $request->validate([
            'lesson_title'              => 'required|string|max:255',
            'lesson_description'        => 'nullable|string',
            'questions'                 => 'required|array|min:1',
            'questions.*.question'      => 'required|string|max:1000',
            'questions.*.type'          => 'required|in:multiple_choice,true_false',
            'questions.*.options'       => 'required|array|min:2',
            'questions.*.options.*.text'=> 'required|string|max:1000',
            'questions.*.correct'       => 'required|integer',
        ]);

        DB::transaction(function () use ($lesson, $request) {
            $lesson->update([
                'title'   => $request->lesson_title,
                'content' => $request->lesson_description ?? null,
            ]);

            // Delete all existing quizzes and recreate
            Quiz::where('lesson_id', $lesson->id)->delete();

            foreach ($request->questions as $index => $questionData) {
                $quiz = Quiz::create([
                    'lesson_id'   => $lesson->id,
                    'question'    => $questionData['question'],
                    'type'        => $questionData['type'],
                    'order_index' => $index + 1,
                ]);

                foreach ($questionData['options'] as $optionIndex => $optionData) {
                    QuizOption::create([
                        'quiz_id'     => $quiz->id,
                        'option_text' => $optionData['text'],
                        'is_correct'  => (int)$questionData['correct'] === (int)$optionIndex,
                    ]);
                }
            }
        });

        return redirect()
            ->route('instructor.quizzes.edit', $lesson)
            ->with('success', 'Quiz berhasil diperbarui.');
    }

    /** DELETE /instructor/quizzes/{quiz} — hapus satu pertanyaan */
    public function destroyQuestion(Quiz $quiz)
    {
        $lesson = $quiz->lesson;
        $this->authorizeInstructorLesson($lesson);

        $quiz->options()->delete();
        $quiz->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }

    private function authorizeInstructorLesson(Lesson $lesson): void
    {
        $belongsToInstructor = $lesson->section
            ->course
            ->instructors()
            ->where('user_id', Auth::id())
            ->exists();

        abort_if(Auth::user()->role !== 'admin' && !$belongsToInstructor, 403, 'Anda tidak punya akses untuk quiz ini.');
    }
}
