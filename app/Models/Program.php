<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'institution_id',
        'category_id',
        'title',
        'slug',
        'type',
        'description',
        'price',
        'thumbnail_url',
        'is_published',
        'duration_months',
        'effort_per_week',
        'what_you_learn',
        'career_outcomes',
        'prerequisites',
        'faq',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'is_published' => 'boolean',
        'what_you_learn' => 'array',
        'faq'          => 'array',
    ];

    // ── Relationships ───────────────────────────────────────────────

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function paymentItems(): HasMany
    {
        return $this->hasMany(PaymentItem::class);
    }

    // ── Scopes ──────────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
