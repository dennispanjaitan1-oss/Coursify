<?php

namespace App\Http\Requests;

use App\Models\Enrollment;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Pastikan user sudah enroll ke course yang di-review.
     */
    public function authorize(): bool
    {
        $course = $this->route('course');

        return Enrollment::where('user_id', $this->user()->id)
                         ->where('course_id', $course->id)
                         ->exists();
    }

    public function rules(): array
    {
        return [
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Rating wajib diisi.',
            'rating.integer'  => 'Rating harus berupa angka.',
            'rating.min'      => 'Rating minimal 1 bintang.',
            'rating.max'      => 'Rating maksimal 5 bintang.',
            'comment.max'     => 'Komentar maksimal 1000 karakter.',
        ];
    }

    protected function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException(
            'Kamu harus terdaftar di kursus ini untuk memberikan review.'
        );
    }
}
