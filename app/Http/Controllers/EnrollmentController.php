<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Wishlist;
use App\Events\NewEnrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function enroll(Request $request, Course $course)
    {
        $user = auth()->user();

        // Cek sudah enroll belum
        if ($user->enrollments()->where('course_id', $course->id)->exists()) {
            return redirect()->route('student.learn', $course->slug)
                ->with('info', 'Kamu sudah terdaftar di kursus ini.');
        }

        if ($course->price == 0) {
            // GRATIS — langsung enroll sebagai audit
            Payment::create([
                'user_id' => $user->id,
                'amount'  => 0,
                'method'  => 'free',
                'status'  => 'paid',
                'paid_at' => now(),
            ]);

            $enrollment = Enrollment::create([
            'user_id'   => $user->id,
            'course_id' => $course->id,
            'type'      => 'audit',
            'status'    => 'active',
        ]);

        // Broadcast event untuk real-time notification
        broadcast(new NewEnrollment($enrollment));

        return redirect()->route('student.learn', $course->slug)
            ->with('success', 'Berhasil enroll! Selamat belajar di kursus ini.');
    }

    // BERBAYAR — untuk sekarang redirect ke halaman checkout sederhana
    return redirect()->route('student.learn', $course->slug)
        ->with('info', 'Fitur pembayaran segera hadir!');
}

    public function toggleWishlist(Course $course)
    {
        $user = auth()->user();
        $wishlist = Wishlist::where('user_id', $user->id)
                            ->where('course_id', $course->id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Dihapus dari wishlist.';
        } else {
            Wishlist::create(['user_id' => $user->id, 'course_id' => $course->id]);
            $message = 'Ditambahkan ke wishlist!';
        }

        return back()->with('success', $message);
    }

    public function submitReview(Request $request, Course $course)
{
    $user = auth()->user();

    // Cek sudah enroll
    $enrollment = Enrollment::where('user_id', $user->id)
        ->where('course_id', $course->id)
        ->first();

    if (!$enrollment) {
        return back()->with('error', 'Kamu belum terdaftar di kursus ini.');
    }

    // Cek sudah selesai 100%
    $totalLessons = $course->sections()->withCount('lessons')->get()->sum('lessons_count');
    $completedLessons = $user->lessonProgress()
    ->whereHas('lesson.section', fn($q) => $q->where('course_id', $course->id))
    ->where('is_completed', true)
    ->count();

    if ($totalLessons === 0 || $completedLessons < $totalLessons) {
        return back()->with('error', 'Kamu harus menyelesaikan semua materi sebelum memberikan review.');
    }

    $request->validate([
        'rating'  => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

    Review::updateOrCreate(
        ['user_id' => $user->id, 'course_id' => $course->id],
        ['rating' => $request->rating, 'comment' => $request->comment]
    );

    return back()->with('success', 'Review berhasil dikirim!');
}

public function unenroll(Enrollment $enrollment)
{
    $user = auth()->user();

    if ($enrollment->user_id !== $user->id) {
        return back()->with('error', 'Tidak diizinkan.');
    }

    $enrollment->delete();

    return back()->with('success', 'Berhasil unenroll dari kursus.');
}

}
