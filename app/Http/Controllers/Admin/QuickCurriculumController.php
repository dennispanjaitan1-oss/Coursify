<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuickCurriculumController extends Controller
{
    /**
     * Display the quick curriculum entry page.
     */
    public function index()
    {
        $courses = Course::orderBy('title')->get(['id', 'title', 'slug']);
        return view('admin.quick-curriculum', compact('courses'));
    }

    /**
     * Save the parsed curriculum data into the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'curriculum_data' => 'required|json',
        ]);

        $courseId = $request->course_id;
        $sections = json_decode($request->curriculum_data, true);

        if (empty($sections)) {
            return back()->with('error', 'Data kurikulum kosong atau tidak valid!');
        }

        DB::transaction(function () use ($courseId, $sections) {
            // Delete old sections and lessons (cascade)
            DB::table('sections')->where('course_id', $courseId)->delete();

            foreach ($sections as $secData) {
                // Insert section
                $sectionId = DB::table('sections')->insertGetId([
                    'course_id' => $courseId,
                    'title' => $secData['title'],
                    'order_index' => $secData['order_index'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert lessons
                if (!empty($secData['lessons'])) {
                    $lessonsToInsert = [];
                    foreach ($secData['lessons'] as $lesData) {
                        $lessonsToInsert[] = [
                            'section_id' => $sectionId,
                            'title' => $lesData['title'],
                            'type' => 'video', // default type
                            'order_index' => $lesData['order_index'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    DB::table('lessons')->insert($lessonsToInsert);
                }
            }
        });

        $course = Course::find($courseId);
        return redirect()->route('admin.quick-curriculum.index')
            ->with('success', "Kurikulum untuk kursus '{$course->title}' berhasil diperbarui!");
    }
}
