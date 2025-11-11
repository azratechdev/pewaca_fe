<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Payment\PaymentLog;
use App\Models\Payment\Settlement;

class Payment extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'order_id',
        'amount',
        'currency',
        'status',
        'qris_payload',
        'provider_trx_id',
        'provider_ref_no',
        'expires_at',
        'paid_at',
        'callback_url',
        'metadata',
        'signature_version',
        'idempotency_key',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
        'signature_version' => 'integer',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(PaymentLog::class);
    }

    public function settlements(): HasMany
    {
        return $this->hasMany(Settlement::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'PENDING';
    }

    public function isPaid(): bool
    {
        return $this->status === 'PAID';
    }

    public function isExpired(): bool
    {
        return $this->status === 'EXPIRED';
    }

    public function canExpire(): bool
    {
        return $this->isPending() && $this->expires_at && $this->expires_at->isPast();
    }
}
