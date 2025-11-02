<?php

namespace App\Jobs\Payment;

use App\Models\Payment\Payment;
use App\Models\Payment\PaymentLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExpirePendingPayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $expiredPayments = Payment::where('status', 'PENDING')
            ->where('expires_at', '<=', now())
            ->get();
            
        $count = 0;
        
        foreach ($expiredPayments as $payment) {
            $payment->update(['status' => 'EXPIRED']);
            
            PaymentLog::create([
                'payment_id' => $payment->id,
                'event' => 'EXPIRE',
                'payload' => [
                    'expired_at' => now()->toIso8601String(),
                    'original_expires_at' => $payment->expires_at->toIso8601String(),
                ],
            ]);
            
            $count++;
        }
        
        if ($count > 0) {
            Log::info('Expired pending payments', ['count' => $count]);
        }
        
        return $count;
    }
}
