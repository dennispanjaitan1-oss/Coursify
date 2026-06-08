<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\CourseSyllabus;

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
        'certificate_price',
        'currency',
        'duration_weeks',
        'difficulty',
        'thumbnail_url',
        'preview_video_url',
        'language',
        'translations',
        'transcripts',
        'prerequisites',
        'is_published',
        'order_index',
        'has_audit_track',
        'audit_access_weeks',
        'upgrade_deadline',
    ];

    protected $casts = [
        'price'             => 'decimal:2',
        'certificate_price' => 'decimal:2',
        'is_published'      => 'boolean',
        'has_audit_track'   => 'boolean',
        'upgrade_deadline'  => 'date',
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

    /** Silabus / subjek yang dipelajari */
    public function syllabus(): HasMany
    {
        return $this->hasMany(CourseSyllabus::class)->orderBy('order_index');
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

    /** Kursus yang menunggu approval admin. */
    public function scopePendingApproval($query)
    {
        return $query->where('is_published', false)->withTrashed(false);
    }

    /** Instruktur hasil scraping dari edX */
public function scrapedInstructors(): HasMany
{
    return $this->hasMany(Instructor::class);
}

    // ── Helpers ─────────────────────────────────────────────────────

    public function isFree(): bool
    {
        return $this->price == 0;
    }

    /** Apakah kursus punya jalur audit (gratis, tanpa sertifikat) */
    public function hasAuditTrack(): bool
    {
        return (bool) $this->has_audit_track;
    }

    /** Apakah kursus punya biaya upgrade ke verified/sertifikat */
    public function hasCertificatePrice(): bool
    {
        return ! is_null($this->certificate_price) && $this->certificate_price > 0;
    }

    /** Apakah user masih bisa upgrade dari audit ke verified */
    public function isUpgradeAvailable(): bool
    {
        if (is_null($this->upgrade_deadline)) {
            return true; // tidak ada deadline = selalu bisa upgrade
        }
        return now()->lessThanOrEqualTo($this->upgrade_deadline);
    }

    /** Apakah akses audit user masih valid (belum expired) */
    public function isAuditAccessExpired(?\DateTime $enrolledAt = null): bool
    {
        if (is_null($this->audit_access_weeks) || is_null($enrolledAt)) {
            return false; // tanpa batas waktu
        }
        $expiry = \Carbon\Carbon::instance($enrolledAt)->addWeeks($this->audit_access_weeks);
        return now()->greaterThan($expiry);
    }

    public function getFormattedPriceAttribute(): string
{
    if ($this->isFree()) return 'GRATIS';
    
    if ($this->currency === 'USD') {
        return '$' . number_format($this->price, 2);
    }
    
    return 'Rp ' . number_format($this->price, 0, ',', '.');
}

public function getFormattedCertificatePriceAttribute(): string
{
    if (! $this->hasCertificatePrice()) {
        return $this->isFree() ? 'Gratis' : 'Included';
    }
    
    if ($this->currency === 'USD') {
        return '$' . number_format($this->certificate_price, 2);
    }
    
    return 'Rp ' . number_format($this->certificate_price, 0, ',', '.');
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
