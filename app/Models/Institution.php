<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institution extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo_url',
        'website_url',
        'description',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    // ── Relationships ───────────────────────────────────────────────

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
