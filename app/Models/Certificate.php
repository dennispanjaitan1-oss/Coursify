<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'enrollment_id', 'certificate_number', 'file_path', 
        'certificate_type', 'status', 'grade', 'issued_at', 'revoked_at'
    ];

    protected $casts = [
        'user_id'       => 'integer',
        'course_id'     => 'integer',
        'enrollment_id' => 'integer',
        'issued_at'  => 'datetime',
        'revoked_at' => 'datetime',
        'grade'      => 'decimal:2',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    // ── Scopes ───────────────────────────────────────────────────────

    /** Sertifikat milik user tertentu */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ── Accessors ────────────────────────────────────────────────────

    /** URL verifikasi publik */
    public function getVerifyUrlAttribute(): string
    {
        return route('certificates.verify', $this->certificate_number);
    }

    /** Tanggal terbit format Indonesia */
    public function getIssuedAtFormattedAttribute(): string
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $date = $this->issued_at ?? $this->created_at;
        return $date->day . ' ' . $months[$date->month] . ' ' . $date->year;
    }
}
