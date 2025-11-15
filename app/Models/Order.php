<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $connection = 'sqlite_backup';

    protected $fillable = [
        'order_number',
        'user_id',
        'store_id',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'notes',
        'customer_name',
        'customer_phone',
        'customer_address',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(uniqid());
            }
        });
    }

    // Removed User relationship - this app uses Django API auth (no local users table)
    // user_id is stored as integer for reference only

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => '<span class="badge bg-warning text-dark">Menunggu</span>',
            'processing' => '<span class="badge bg-info">Diproses</span>',
            'completed' => '<span class="badge bg-success">Selesai</span>',
            'cancelled' => '<span class="badge bg-danger">Dibatalkan</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getPaymentStatusBadgeAttribute(): string
    {
        $badges = [
            'unpaid' => '<span class="badge bg-danger">Belum Bayar</span>',
            'paid' => '<span class="badge bg-success">Sudah Bayar</span>',
            'refunded' => '<span class="badge bg-warning text-dark">Refund</span>',
        ];

        return $badges[$this->payment_status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }
}
