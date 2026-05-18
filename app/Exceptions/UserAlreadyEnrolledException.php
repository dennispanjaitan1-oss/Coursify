<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class UserAlreadyEnrolledException extends Exception
{
    protected string $courseSlug;

    public function __construct(
        string $message = 'Kamu sudah terdaftar di kursus ini.',
        string $courseSlug = ''
    ) {
        parent::__construct($message, 409);
        $this->courseSlug = $courseSlug;
    }

    /**
     * Render exception ke HTTP response.
     */
    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $this->getMessage(),
            ], 409);
        }

        // Redirect ke halaman belajar jika slug tersedia, atau kembali
        if ($this->courseSlug) {
            return redirect()
                ->route('student.learn', $this->courseSlug)
                ->with('info', $this->getMessage());
        }

        return back()->with('info', $this->getMessage());
    }

    public function getCourseSlug(): string
    {
        return $this->courseSlug;
    }
}
