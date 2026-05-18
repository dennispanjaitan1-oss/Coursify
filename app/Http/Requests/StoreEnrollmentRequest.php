<?php

namespace App\Http\Requests;

use App\Models\Enrollment;
use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    /**
     * Pastikan user belum terdaftar di course ini.
     */
    public function authorize(): bool
    {
        $course = $this->route('course');

        if (!$course) {
            return false;
        }

        $alreadyEnrolled = Enrollment::where('user_id', $this->user()->id)
                                     ->where('course_id', $course->id)
                                     ->exists();

        // Authorize = true hanya jika BELUM enrolled
        return !$alreadyEnrolled;
    }

    public function rules(): array
    {
        // Enrollment dipicu via route /{course}/enroll, tidak ada body fields wajib.
        // Tambahkan validasi jika ada input form di masa depan.
        return [];
    }

    protected function failedAuthorization()
    {
        $course = $this->route('course');
        $slug   = $course?->slug ?? '';

        throw new \App\Exceptions\UserAlreadyEnrolledException(
            'Kamu sudah terdaftar di kursus ini.',
            $slug
        );
    }
}
