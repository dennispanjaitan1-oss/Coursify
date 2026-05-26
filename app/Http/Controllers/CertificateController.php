<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Generate sertifikat untuk kursus yang sudah selesai.
     * Dipanggil jika sertifikat belum otomatis dibuat.
     *
     * POST /dashboard/certificates/{course}/generate
     */
    public function generate(Course $course)
    {
        $user = Auth::user();

        // Cek enrollment & status completed
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (! $enrollment) {
            return back()->with('error', 'Kamu belum terdaftar di kursus ini.');
        }

        if ($enrollment->progress_percent < 100) {
            return back()->with('error', 'Selesaikan semua materi terlebih dahulu. Progress kamu: ' . $enrollment->progress_percent . '%');
        }

        if (!in_array($enrollment->type, ['verified', 'honor'])) {
            return back()->with('error', 'Sertifikat hanya tersedia untuk jalur Verified. Silakan upgrade ke Verified terlebih dahulu.');
        }

        // Cegah duplikat
        $existing = Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existing) {
            return back()->with('info', 'Sertifikat sudah pernah diterbitkan.');
        }

        // Buat sertifikat
        Certificate::create([
            'user_id'            => $user->id,
            'course_id'          => $course->id,
            'enrollment_id'      => $enrollment->id,
            'certificate_type'   => $enrollment->type,
            'certificate_number' => $this->generateUniqueNumber(),
            'issued_at'          => now(),
        ]);

        return back()->with('success', 'Sertifikat berhasil diterbitkan!');
    }

    /**
     * Download sertifikat sebagai PDF.
     *
     * GET /dashboard/certificates/{certificate}/download
     */
    public function download(Certificate $certificate)
    {
        $user = Auth::user();

        if (!$user || ($user->id !== $certificate->user_id && !$user->hasRole('admin'))) {
            abort(403, 'Kamu tidak memiliki akses ke sertifikat ini.');
        }

        $certificate->loadMissing(['user', 'course', 'course.institution', 'course.instructors']);

        if (!$certificate->course) {
            abort(404, 'Kursus terkait sertifikat ini tidak ditemukan.');
        }

        $pdf = PDF::loadView('certificates.pdf', [
            'certificate' => $certificate,
            'user'        => $certificate->user,
            'course'      => $certificate->course,
        ])
        ->setPaper('a4', 'landscape')
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled'      => true,
            'defaultFont'          => 'sans-serif',
            'dpi'                  => 150,
        ]);

        $filename = 'Sertifikat-' . Str::slug($certificate->course->title) . '-' . $certificate->certificate_number . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Stream/preview sertifikat di browser (tanpa download).
     *
     * GET /dashboard/certificates/{certificate}/preview
     */
    public function preview(Certificate $certificate)
    {
        $user = Auth::user();

        if (!$user || ($user->id !== $certificate->user_id && !$user->hasRole('admin'))) {
            abort(403, 'Kamu tidak memiliki akses ke sertifikat ini.');
        }

        $certificate->loadMissing(['user', 'course', 'course.institution', 'course.instructors']);

        if (!$certificate->course) {
            abort(404, 'Kursus terkait sertifikat ini tidak ditemukan.');
        }

        $pdf = PDF::loadView('certificates.pdf', [
            'certificate' => $certificate,
            'user'        => $certificate->user,
            'course'      => $certificate->course,
        ])
        ->setPaper('a4', 'landscape')
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled'      => true,
            'defaultFont'          => 'sans-serif',
            'dpi'                  => 150,
        ]);

        return $pdf->stream();
    }

    /**
     * Verifikasi keaslian sertifikat (public, tanpa auth).
     *
     * GET /verify/{certificateNumber}
     */
    public function verify(string $certificateNumber)
    {
        $certificate = Certificate::where('certificate_number', $certificateNumber)
            ->with(['user', 'course', 'course.institution'])
            ->first();

        if (! $certificate) {
            return view('certificates.verify', [
                'valid'       => false,
                'certificate' => null,
            ]);
        }

        return view('certificates.verify', [
            'valid'       => true,
            'certificate' => $certificate,
        ]);
    }

    /**
     * Generate nomor sertifikat unik.
     * Format: CERT-YYYY-XXXXXXXX
     */
    private function generateUniqueNumber(): string
    {
        do {
            $number = 'CERT-' . date('Y') . '-' . strtoupper(Str::random(8));
        } while (Certificate::where('certificate_number', $number)->exists());

        return $number;
    }
}