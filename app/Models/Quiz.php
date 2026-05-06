<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $fillable = [
        'lesson_id',
        'question',
        'type',           // 'multiple_choice' | 'true_false'
        'order_index',
    ];

    // ── Relationships ───────────────────────────────────────────────

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuizOption::class);
    }

    public function correctOption()
    {
        return $this->options()->where('is_correct', true)->first();
    }
}
