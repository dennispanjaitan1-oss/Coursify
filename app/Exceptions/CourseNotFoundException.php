<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseNotFoundException extends Exception
{
    public function __construct(string $message = 'Kursus tidak ditemukan.', int $code = 404)
    {
        parent::__construct($message, $code);
    }

    /**
     * Render exception ke HTTP response.
     * Otomatis dipanggil oleh Laravel Exception Handler.
     */
    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $this->getMessage(),
            ], 404);
        }

        return redirect()
            ->route('courses.index')
            ->with('error', $this->getMessage());
    }
}
