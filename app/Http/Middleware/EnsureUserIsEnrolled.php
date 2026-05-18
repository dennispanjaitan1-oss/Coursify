<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Course;

class EnsureUserIsEnrolled
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        // Dapatkan slug kursus dari route parameter
        $slug = $request->route('slug');
        if (!$slug && $request->route('course')) {
            $course = $request->route('course');
            $slug = is_string($course) ? $course : $course->slug;
        }

        if (!$slug) {
            return $next($request); // Abaikan jika tidak ada parameter kursus
        }

        $course = Course::where('slug', $slug)->first();

        if (!$course) {
            abort(404, 'Kursus tidak ditemukan.');
        }

        // Cek apakah user adalah admin atau instructor dari kursus ini
        if ($user->role === 'admin' || $course->instructors()->where('users.id', $user->id)->exists()) {
            return $next($request);
        }

        // Cek apakah student sudah enroll dan statusnya active/completed
        $isEnrolled = $user->enrollments()
            ->where('course_id', $course->id)
            ->whereIn('status', ['active', 'completed'])
            ->exists();

        if (!$isEnrolled) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Anda harus mendaftar kursus ini terlebih dahulu untuk mengakses materi.');
        }

        return $next($request);
    }
}
