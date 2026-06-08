<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Certificate;
use App\Events\NewEnrollment;
use App\Mail\EnrollmentMail;
use App\Mail\CourseCompletionMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EnrollmentController extends Controller
{
    public function enroll(Request $request, Course $course)
    {
        $user = auth()->user();

        $request->validate([
            'track' => 'nullable|in:audit,verified,honor'
        ]);
        
        $track = $request->input('track', 'audit');

        // Jika course TIDAK punya jalur audit, paksa jadi verified
        if ($track === 'audit' && !$course->hasAuditTrack()) {
            $track = 'verified'; 
        }



        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        // Mode Upgrade jika sudah enroll sebagai audit
        if ($enrollment) {
            if ($enrollment->type === 'audit' && in_array($track, ['verified', 'honor'])) {
                if (!$course->isUpgradeAvailable()) {
                    return back()->with('error', 'Batas waktu upgrade ke Verified sudah berakhir.');
                }
                
                // Jika sertifikat disertakan gratis
                if (!$course->hasCertificatePrice() && $course->isFree()) {
                    $enrollment->update([
                        'type' => $track,
                        'upgraded_at' => now(),
                    ]);

                    // Jika siswa sudah menyelesaikan kursus 100%, terbitkan sertifikat & kirim email
                    if ($enrollment->progress_percent >= 100) {
                        $alreadyHasCert = Certificate::where('user_id', $user->id)
                            ->where('course_id', $course->id)
                            ->exists();

                        if (!$alreadyHasCert) {
                            try {
                                $cert = Certificate::create([
                                    'user_id'            => $user->id,
                                    'course_id'          => $course->id,
                                    'enrollment_id'      => $enrollment->id,
                                    'certificate_type'   => $enrollment->type,
                                    'certificate_number' => 'CERT-' . date('Y') . '-' . strtoupper(Str::random(8)),
                                    'issued_at'          => now(),
                                ]);

                                Mail::to($user->email)->send(new CourseCompletionMail($user, $course, $cert));
                            } catch (\Exception $e) {
                                logger()->error('Free upgrade certificate/email failed: ' . $e->getMessage());
                            }
                        }
                    }

                    return redirect()->route('student.learn', $course->slug)
                        ->with('success', 'Berhasil upgrade ke jalur Verified!');
                }
                
                return redirect()->route('payment.index', [
                    'course'  => $course->id, 
                    'upgrade' => 1,
                    'track'   => $track
                ])->with('info', 'Silakan selesaikan pembayaran untuk upgrade ke Verified.');
            }
            
            return redirect()->route('student.learn', $course->slug)
                ->with('info', 'Kamu sudah terdaftar di kursus ini.');
        }

        // Pendaftaran baruu
        $isFreeEnrollment = ($track === 'audit');

        if ($isFreeEnrollment) {
            $payment = Payment::create([
                'user_id' => $user->id,
                'amount'  => 0,
                'method'  => 'free',
                'status'  => 'paid',
                'paid_at' => now(),
                'currency' => $course->currency ?: 'IDR',
                'transaction_id' => 'AUDIT-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(8)),
            ]);

            $payment->items()->create([
                'course_id' => $course->id,
                'item_type' => 'course',
                'price' => 0,
            ]);

            $newEnrollment = Enrollment::create([
                'user_id'   => $user->id,
                'course_id' => $course->id,
                'payment_id' => $payment->id,
                'type'      => $track,
                'status'    => 'active',
            ]);

            broadcast(new NewEnrollment($newEnrollment));

            // Kirim email notifikasi enrollment
            try {
                Mail::to($user->email)->send(new EnrollmentMail($user, $course));
            } catch (\Exception $e) {
                logger()->warning('Enrollment notification email failed to send: ' . $e->getMessage());
            }

            return redirect()->route('student.learn', $course->slug)
                ->with('success', 'Berhasil enroll! Selamat belajar.');
        }

        // Pendaftaran berbayar (verified)
        return redirect()->route('payment.index', [
            'course' => $course->id,
            'track'  => $track
        ])->with('info', 'Silakan selesaikan pembayaran.');
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
