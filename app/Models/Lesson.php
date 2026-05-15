<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = [
        'section_id',
        'title',
        'type',                 // 'video' | 'article' | 'quiz'
        'video_url',
        'content',
        'duration_seconds',
        'order_index',
        'is_free_preview',
    ];

    protected $casts = [
        'is_free_preview' => 'boolean',
    ];

    // ── Relationships ───────────────────────────────────────────────

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /** Shortcut ke course melalui section */
    public function course()
    {
        return $this->section->course;
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class)->orderBy('order_index');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

    // ── Helpers ─────────────────────────────────────────────────────

    public function getDurationFormattedAttribute(): string
    {
        $mins = intdiv($this->duration_seconds, 60);
        $secs = $this->duration_seconds % 60;
        return sprintf('%d:%02d', $mins, $secs);
    }

    public function progresses()
{
    return $this->hasMany(LessonProgress::class);
}

public function isCompletedBy($user)
{
    return $this->progresses()
        ->where('user_id', $user->id)
        ->exists();
}

}
