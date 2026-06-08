<?php

namespace App\Http\Controllers;

use App\Mail\EnrollmentMail;
use App\Mail\CourseCompletionMail;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Certificate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $course = Course::with(['institution'])
            ->withCount('enrollments')
            ->find($request->query('course'));

        if (! $course) {
            return redirect()->route('courses.index')
                ->with('info', 'Pilih course terlebih dahulu sebelum checkout.');
        }

        $track = $request->query('track', 'verified');
        $isUpgrade = $request->boolean('upgrade');
        $price = $this->resolvePrice($course, $track);

        if ($price <= 0) {
            return redirect()->route('courses.show', $course)
                ->with('info', 'Course ini tidak membutuhkan pembayaran.');
        }

        $alreadyVerified = Enrollment::where('user_id', $request->user()->id)
            ->where('course_id', $course->id)
            ->whereIn('type', ['verified', 'honor'])
            ->exists();

        if ($alreadyVerified) {
            return redirect()->route('student.learn', $course->slug)
                ->with('info', 'Kamu sudah memiliki akses verified untuk course ini.');
        }

        return view('payment', compact('course', 'track', 'isUpgrade', 'price'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'track' => ['required', 'in:verified,honor'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'card_number' => ['required', 'string', 'min:13', 'max:24'],
            'card_expiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
            'card_cvc' => ['required', 'digits_between:3,4'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
        ]);

        $course = Course::findOrFail($validated['course_id']);
        $user = $request->user();
        $track = $validated['track'];
        $price = $this->resolvePrice($course, $track);

        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment && in_array($existingEnrollment->type, ['verified', 'honor'])) {
            return redirect()->route('student.learn', $course->slug)
                ->with('info', 'Kamu sudah memiliki akses Verified untuk course ini.');
        }

        if ($price <= 0) {
            return redirect()->route('courses.show', $course)
                ->with('info', 'Course ini tidak membutuhkan pembayaran.');
        }

        $couponCode = filled($validated['coupon_code'])
            ? Str::upper($validated['coupon_code'])
            : null;
        $discount = $couponCode === 'COURSIFY10' ? round($price * 0.10, 2) : 0;
        $total = max(0, $price - $discount);
        $cardNumber = preg_replace('/\D/', '', $validated['card_number']);

        $result = DB::transaction(function () use ($user, $course, $track, $validated, $couponCode, $discount, $price, $total, $cardNumber, $request) {
            $payment = Payment::create([
                'user_id' => $user->id,
                'amount' => $total,
                'currency' => $course->currency ?: 'IDR',
                'method' => 'kartu_kredit',
                'status' => 'paid',
                'transaction_id' => 'CRS-' . now()->format('Ymd') . '-' . Str::upper(Str::random(8)),
                'paid_at' => now(),
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'country' => $validated['country'],
                'billing_email' => $user->email,
                'card_last4' => substr($cardNumber, -4),
                'card_brand' => self::detectCardBrand($cardNumber),
                'card_expiry' => $validated['card_expiry'],
                'coupon_code' => $couponCode,
                'discount_amount' => $discount,
                'original_amount' => $price,
                'final_amount' => $total,
                'ip_address' => $request->ip(),
            ]);

            $payment->items()->create([
                'course_id' => $course->id,
                'item_type' => 'course',
                'price' => $price,
            ]);

            $enrollment = Enrollment::firstOrNew([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);

            $enrollment->payment_id = $payment->id;
            $enrollment->type = $track;
            $enrollment->upgraded_at = now();

            if (! $enrollment->exists) {
                $enrollment->status = 'active';
            }

            $enrollment->save();

            return ['payment' => $payment, 'enrollment' => $enrollment];
        });

        $payment = $result['payment'];
        $enrollment = $result['enrollment'];

        // Kirim email notifikasi enrollment setelah transaksi berhasil
        try {
            Mail::to($user->email)->send(new EnrollmentMail($user, $course));
        } catch (\Exception $e) {
            logger()->warning('Payment enrollment notification email failed to send: ' . $e->getMessage());
        }

        // KASUS KHUSUS: Jika siswa upgrade ke verified/honor DAN progres belajarnya sudah 100% (sebelumnya di jalur audit)
        if ($enrollment && $enrollment->progress_percent >= 100 && in_array($enrollment->type, ['verified', 'honor'])) {
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

                    // Kirim email kelulusan mewah dengan lampiran PDF sertifikat
                    Mail::to($user->email)->send(new CourseCompletionMail($user, $course, $cert));
                } catch (\Exception $e) {
                    logger()->error('Failed to issue certificate/send mail during upgrade: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('payment.confirmation', $payment);
    }

    public function confirmation(Payment $payment)
    {
        abort_unless($payment->user_id === auth()->id(), 403);

        $payment->load(['items.course.institution', 'user']);
        $course = $payment->items->first()?->course;

        abort_unless($course, 404);

        return view('payment-confirmation', compact('payment', 'course'));
    }

    private function resolvePrice(Course $course, string $track): float
    {
        if ($track === 'verified') {
            if ($course->hasCertificatePrice()) {
                return (float) $course->certificate_price;
            }
            return 499000.0; // Default fallback for Verified track
        }

        return (float) $course->price;
    }

    private static function detectCardBrand(string $cardNumber): string
    {
        if (str_starts_with($cardNumber, '4')) {
            return 'visa';
        }

        if (preg_match('/^5[1-5]/', $cardNumber)) {
            return 'mastercard';
        }

        if (preg_match('/^3[47]/', $cardNumber)) {
            return 'amex';
        }

        if (preg_match('/^35(2[89]|[3-8])/', $cardNumber)) {
            return 'jcb';
        }

        return 'card';
    }
}
