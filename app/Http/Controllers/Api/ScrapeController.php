<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScrapeController extends Controller
{
    public function next()
    {
        // Get a course that has no description OR no syllabus OR no sections
        $courseIdsWithSyllabus = DB::table('course_syllabus')->select('course_id')->distinct()->pluck('course_id');
        $courseIdsWithSections = DB::table('sections')->select('course_id')->distinct()->pluck('course_id');
        
        $course = Course::whereNull('description')
            ->orWhereNotIn('id', $courseIdsWithSyllabus)
            ->orWhereNotIn('id', $courseIdsWithSections)
            ->first();

        if (!$course) {
            return response()->json(['status' => 'done']);
        }

        // Return title to be searched on Google/DuckDuckGo
        return response()->json([
            'status' => 'ok',
            'course' => [
                'id' => $course->id,
                'title' => $course->title,
            ]
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'syllabus' => 'nullable|array'
        ]);

        $course = Course::find($request->course_id);

        if ($request->has('description') && $request->description) {
            $course->description = $request->description;
            $course->save();
        }

        if ($request->has('syllabus') && is_array($request->syllabus) && count($request->syllabus) > 0) {
            DB::table('course_syllabus')->where('course_id', $course->id)->delete();
            $insertData = [];
            foreach ($request->syllabus as $index => $item) {
                $insertData[] = [
                    'course_id' => $course->id,
                    'item' => $item,
                    'order_index' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('course_syllabus')->insert($insertData);
        }

        // Save Curriculum (Sections & Lessons)
        if ($request->has('curriculum') && is_array($request->curriculum) && count($request->curriculum) > 0) {
            DB::table('sections')->where('course_id', $course->id)->delete();
            foreach ($request->curriculum as $secData) {
                $sectionId = DB::table('sections')->insertGetId([
                    'course_id' => $course->id,
                    'title' => $secData['title'],
                    'order_index' => $secData['order_index'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                if (!empty($secData['lessons'])) {
                    $lessonsToInsert = [];
                    foreach ($secData['lessons'] as $lesData) {
                        $lessonsToInsert[] = [
                            'section_id' => $sectionId,
                            'title' => $lesData['title'],
                            'type' => 'video',
                            'order_index' => $lesData['order_index'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    DB::table('lessons')->insert($lessonsToInsert);
                }
            }
        } else {
            // Mark it as scraped but failed to find syllabus, so we don't loop infinitely
            // Let's just insert a dummy so it doesn't get picked up again
            DB::table('course_syllabus')->insert([
                'course_id' => $course->id,
                'item' => 'Syllabus not available on edX.',
                'order_index' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['status' => 'success']);
    }
}
