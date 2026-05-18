<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Hanya instructor (pemilik kursus) atau admin yang boleh update.
     */
    public function authorize(): bool
    {
        return $this->user()?->isInstructor() ?? false;
    }

    public function rules(): array
    {
        // Ambil ID kursus dari route parameter (bisa berupa model atau integer)
        $course   = $this->route('course');
        $courseId = is_object($course) ? $course->id : $course;

        return [
            'title'             => ['required', 'string', 'max:255'],
            'slug'              => ['required', 'string', 'max:255', Rule::unique('courses', 'slug')->ignore($courseId)],
            'short_description' => ['required', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'price'             => ['required', 'numeric', 'min:0'],
            'difficulty'        => ['required', Rule::in(['beginner', 'intermediate', 'advanced'])],
            'category_id'       => ['required', 'integer', 'exists:categories,id'],
            'institution_id'    => ['nullable', 'integer', 'exists:institutions,id'],
            'program_id'        => ['nullable', 'integer', 'exists:programs,id'],
            'duration_weeks'    => ['nullable', 'integer', 'min:1', 'max:104'],
            'language'          => ['nullable', 'string', 'max:10'],
            'thumbnail_url'     => ['nullable', 'url', 'max:500'],
            'preview_video_url' => ['nullable', 'url', 'max:500'],
            'is_published'      => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'             => 'Judul kursus wajib diisi.',
            'slug.required'              => 'Slug wajib diisi.',
            'slug.unique'                => 'Slug sudah digunakan oleh kursus lain.',
            'short_description.required' => 'Deskripsi singkat wajib diisi.',
            'price.required'             => 'Harga wajib diisi.',
            'price.min'                  => 'Harga tidak boleh negatif.',
            'difficulty.required'        => 'Tingkat kesulitan wajib dipilih.',
            'difficulty.in'              => 'Tingkat kesulitan harus: beginner, intermediate, atau advanced.',
            'category_id.required'       => 'Kategori wajib dipilih.',
            'category_id.exists'         => 'Kategori tidak valid.',
        ];
    }
}
