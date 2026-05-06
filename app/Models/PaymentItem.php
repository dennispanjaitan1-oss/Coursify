<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentItem extends Model
{
    protected $fillable = [
        'payment_id',
        'course_id',
        'program_id',
        'item_type',    // 'course' | 'program'
        'price',
    ];

    protected $casts = ['price' => 'decimal:2'];

    // ── Relationships ───────────────────────────────────────────────

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
