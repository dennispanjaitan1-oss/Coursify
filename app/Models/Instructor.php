<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Instructor extends Model
{
    protected $fillable = [
        'course_id',
        'name',
        'title',
        'photo_url',
        'institution_logo_url',
    ];
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}