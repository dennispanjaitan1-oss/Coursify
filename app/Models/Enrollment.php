<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'payment_id',
        'type',             // 'audit' | 'verified'
        'status',           // 'active' | 'completed' | 'refunded'
        'progress_percent',
        'completed_at',
    ];

    protected $casts = [
        'progress_percent' => 'decimal:2',
        'completed_at'     => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    // ── Helpers ─────────────────────────────────────────────────────

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function getProgressBarWidthAttribute(): string
    {
        return round($this->progress_percent) . '%';
    }
}
