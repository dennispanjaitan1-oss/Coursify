<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',          // 'student' | 'instructor' | 'admin'
        'bio',
        'avatar_url',
        'headline',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ── Relationships ───────────────────────────────────────────────

    /** Kursus yang diajar user ini (sebagai instruktur) */
    public function coursesTaught()
    {
        return $this->belongsToMany(Course::class, 'course_instructors', 'user_id', 'course_id')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /** Enrollment / pendaftaran kursus */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /** Kursus yang sudah dienroll (shortcut) */
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->withPivot(['type', 'status', 'progress_percent', 'completed_at'])
                    ->withTimestamps();
    }

    /** Sertifikat yang dimiliki user */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    /** Wishlist user */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /** Review yang ditulis user */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /** Pembayaran user */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /** Progress belajar per lesson */
    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    // ── Helpers ─────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isInstructor(): bool
    {
        return in_array($this->role, ['instructor', 'admin']);
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function getAvatarInitialAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 1));
    }
}