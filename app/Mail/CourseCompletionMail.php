<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Course;
use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Str;

class CourseCompletionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Course $course,
        public ?Certificate $certificate = null
    ) {}

    public function build()
    {
        $email = $this
            ->subject("Selamat! Kamu Menyelesaikan: {$this->course->title} 🎓")
            ->view('emails.course-completion');

        // Jika ada sertifikat, buat PDF & attach langsung ke email
        if ($this->certificate) {
            try {
                $this->certificate->loadMissing(['user', 'course', 'course.institution', 'course.instructors']);
                
                $pdf = PDF::loadView('certificates.pdf', [
                    'certificate' => $this->certificate,
                    'user'        => $this->user,
                    'course'      => $this->course,
                ])
                ->setPaper('a4', 'landscape')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled'      => true,
                    'defaultFont'          => 'sans-serif',
                    'dpi'                  => 150,
                ]);

                $filename = 'Sertifikat-' . Str::slug($this->course->title) . '-' . $this->certificate->certificate_number . '.pdf';

                $email->attachData($pdf->output(), $filename, [
                    'mime' => 'application/pdf',
                ]);
            } catch (\Exception $e) {
                logger()->error('Failed to attach certificate PDF in email: ' . $e->getMessage());
            }
        }

        return $email;
    }
}
