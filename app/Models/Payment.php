<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'method',           // 'transfer_bank' | 'kartu_kredit' | 'gopay' | 'ovo' | 'dana' | 'qris' | 'free'
        'status',           // 'pending' | 'paid' | 'failed' | 'refunded'
        'transaction_id',
        'snap_token',
        'paid_at',
        'first_name',
        'last_name',
        'country',
        'billing_email',
        'card_last4',
        'card_brand',
        'card_expiry',
        'coupon_code',
        'discount_amount',
        'original_amount',
        'final_amount',
        'ip_address',
    ];

    protected $casts = [
        'user_id'         => 'integer',
        'amount'          => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'original_amount' => 'decimal:2',
        'final_amount'    => 'decimal:2',
        'paid_at'         => 'datetime',
    ];

    // ── Relationships ───────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PaymentItem::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    // ── Scopes ──────────────────────────────────────────────────────

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    // ── Helpers ─────────────────────────────────────────────────────

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
