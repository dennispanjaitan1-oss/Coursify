<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnrollmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Course $course
    ) {}

    public function build()
    {
        return $this
            ->subject("Pendaftaran Berhasil: {$this->course->title}")
            ->view('emails.enrollment');
    }
}