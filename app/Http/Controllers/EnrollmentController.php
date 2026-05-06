<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Wishlist;
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

            Enrollment::create([
                'user_id'   => $user->id,
                'course_id' => $course->id,
                'type'      => 'audit',
                'status'    => 'active',
            ]);

            return redirect()->route('student.learn', $course->slug)
                ->with('success', 'Berhasil enroll! Selamat belajar 🎉');
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
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            ['user_id' => auth()->id(), 'course_id' => $course->id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return back()->with('success', 'Review berhasil dikirim!');
    }
}
