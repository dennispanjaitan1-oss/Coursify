<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'rating',
        'comment',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    // ── Relationships ───────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // ── Scopes ──────────────────────────────────────────────────────

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
}
