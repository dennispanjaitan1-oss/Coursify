<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ProgramCertificate extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'program_id',
        'status',
        'issued_at',
        'revoked_at',
    ];

    protected $casts = [
        'issued_at'  => 'datetime',
        'revoked_at' => 'datetime',
    ];

    // ── Boot ────────────────────────────────────────────────────────

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($cert) {
            if (empty($cert->uuid)) {
                $cert->uuid = (string) Str::uuid();
            }
        });
    }

    // ── Relationships ───────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    // ── Helpers ─────────────────────────────────────────────────────

    public function isValid(): bool
    {
        return $this->status === 'downloadable' && is_null($this->revoked_at);
    }

    public function getVerifyUrlAttribute(): string
    {
        return url('/verify/program/' . $this->uuid);
    }
}
