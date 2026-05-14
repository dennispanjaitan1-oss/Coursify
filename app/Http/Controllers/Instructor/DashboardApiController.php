<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Review;

class DashboardApiController extends Controller
{
    public function getStats()
    {
        $instructor = Auth::user();
        $courseIds = $instructor->coursesTaught()->pluck('courses.id');

        return response()->json([
            'publishedCount' => Course::whereIn('id', $courseIds)->where('is_published', true)->count(),
            'studentsCount' => Enrollment::whereIn('course_id', $courseIds)->distinct('user_id')->count('user_id'),
            'avgRating' => Review::whereIn('course_id', $courseIds)->avg('rating') ?? 0,
        ]);
    }
}
