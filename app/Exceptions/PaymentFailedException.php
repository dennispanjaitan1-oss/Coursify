<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class PaymentFailedException extends Exception
{
    protected ?string $transactionId;

    public function __construct(
        string $message = 'Pembayaran gagal, silakan coba lagi.',
        ?string $transactionId = null,
        int $code = 402
    ) {
        parent::__construct($message, $code);
        $this->transactionId = $transactionId;
    }

    /**
     * Render exception ke HTTP response.
     */
    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success'        => false,
                'message'        => $this->getMessage(),
                'transaction_id' => $this->transactionId,
            ], 402);
        }

        return back()->with('error', $this->getMessage());
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }
}
