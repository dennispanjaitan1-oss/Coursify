<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Wishlist;
use App\Events\NewEnrollment;
use App\Exceptions\UserAlreadyEnrolledException;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\StoreReviewRequest;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function __construct(
        protected EnrollmentService $enrollmentService
    ) {}

    public function enroll(StoreEnrollmentRequest $request, Course $course)
    {
        $user = auth()->user();

        if ($course->price == 0) {
            $this->enrollmentService->enrollFreeCourse($user, $course);

            return redirect()->route('student.learn', $course->slug)
                ->with('success', 'Berhasil enroll! Selamat belajar.');
        }

        // Berbayar → arahkan ke halaman payment
        return redirect()->route('payment.index', ['course' => $course->id])
            ->with('info', 'Silakan selesaikan pembayaran.');
    }

    public function toggleWishlist(Course $course)
    {
        $message = $this->enrollmentService->toggleWishlist(auth()->user(), $course);

        return back()->with('success', $message);
    }

    public function submitReview(StoreReviewRequest $request, Course $course)
    {
        $user = auth()->user();

        // Cek progress — harus selesai 100% sebelum bisa review
        if (!$this->enrollmentService->canSubmitReview($user, $course)) {
            return back()->with('error', 'Kamu harus menyelesaikan semua materi sebelum memberikan review.');
        }

        $this->enrollmentService->submitReview($user, $course, $request->rating, $request->comment);

        return back()->with('success', 'Review berhasil dikirim!');
    }

public function unenroll(Enrollment $enrollment)
{
    $user = auth()->user();

    if (!$this->enrollmentService->unenroll($user, $enrollment)) {
        return back()->with('error', 'Tidak diizinkan.');
    }

    return back()->with('success', 'Berhasil unenroll dari kursus.');
}

}
