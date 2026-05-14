<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'program_id',
        'institution_id',
        'category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'price',
        'duration_weeks',
        'difficulty',
        'thumbnail_url',
        'preview_video_url',
        'language',
        'is_published',
        'order_index',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'is_published' => 'boolean',
    ];

    // ── Relationships ───────────────────────────────────────────────

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** Instruktur (Many-to-Many via course_instructors) */
    public function instructors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_instructors', 'course_id', 'user_id')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /** Bagian / modul kursus */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('order_index');
    }

    /** Semua lesson (melalui sections) */
    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(Lesson::class, Section::class);
    }

    /** Pendaftar kursus */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /** User yang terdaftar (Many-to-Many shortcut) */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments')
                    ->withPivot(['type', 'status', 'progress_percent', 'completed_at'])
                    ->withTimestamps();
    }

    /** Ulasan / review */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /** Sertifikat yang dikeluarkan kursus ini */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    /** Wishlist */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /** Item pembayaran */
    public function paymentItems(): HasMany
    {
        return $this->hasMany(PaymentItem::class);
    }

    // ── Scopes ──────────────────────────────────────────────────────

    /** Hanya kursus yang sudah dipublikasi */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /** Hanya kursus gratis */
    public function scopeFree($query)
    {
        return $query->where('price', 0);
    }

    /** Hanya kursus berbayar */
    public function scopePaid($query)
    {
        return $query->where('price', '>', 0);
    }

    // ── Helpers ─────────────────────────────────────────────────────

    public function isFree(): bool
    {
        return $this->price == 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return $this->isFree()
            ? 'GRATIS'
            : 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getTotalLessonsAttribute(): int
    {
        return $this->sections->flatMap->lessons->count();
    }

    public function getRouteKeyName()
{
    return 'slug';
}
}