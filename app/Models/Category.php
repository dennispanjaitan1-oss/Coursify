<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id', 'icon'];

    // ── Relationships ─────────────────────────────────────

    /** Subkategori (self-referencing) */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /** Kategori induk */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /** Semua kursus di kategori ini */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /** Program di kategori ini */
    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}