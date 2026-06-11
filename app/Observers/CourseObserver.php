<?php

namespace App\Observers;

use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class CourseObserver
{
    public function forceDeleted(Course $course): void
    {
        if ($course->thumbnail_url) {
            $path = str_replace('storage/', '', $course->thumbnail_url);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        if ($course->preview_video_url) {
            $path = str_replace('storage/', '', $course->preview_video_url);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
