<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class WebhookEvent extends Model
{
    use HasUuids;
    
    public $timestamps = false;
    
    protected $fillable = [
        'provider',
        'event_id',
        'payload',
        'received_at',
        'processed_at',
        'status',
        'error_message',
    ];

    protected $casts = [
        'payload' => 'array',
        'received_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    public function markAsProcessed(): void
    {
        $this->update([
            'processed_at' => now(),
            'status' => 'OK',
        ]);
    }

    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'processed_at' => now(),
            'status' => 'ERROR',
            'error_message' => $errorMessage,
        ]);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($event) {
            if (!$event->received_at) {
                $event->received_at = now();
            }
        });
    }
}
