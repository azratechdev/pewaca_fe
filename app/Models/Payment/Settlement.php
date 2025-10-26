<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settlement extends Model
{
    protected $connection = 'sqlite';
    
    public $timestamps = false;
    
    protected $fillable = [
        'provider_trx_id',
        'payment_id',
        'amount',
        'fee',
        'net_amount',
        'settlement_date',
        'file_id',
        'reconciled',
        'created_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'settlement_date' => 'date',
        'reconciled' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function markAsReconciled(): void
    {
        $this->update(['reconciled' => true]);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($settlement) {
            if (!$settlement->created_at) {
                $settlement->created_at = now();
            }
            if (!isset($settlement->net_amount)) {
                $settlement->net_amount = $settlement->amount - $settlement->fee;
            }
        });
    }
}
