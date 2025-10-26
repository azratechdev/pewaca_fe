<?php

namespace App\Jobs\Payment;

use App\Models\Payment\Settlement;
use App\Models\Payment\Payment;
use App\Models\Payment\PaymentLog;
use App\Services\Qris\QrisProvider;
use App\Services\Qris\QrisProviderMock;
use App\Services\Qris\QrisProviderMidtrans;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ReconcileDaily implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private \DateTime $date;
    
    public function __construct(?\DateTime $date = null)
    {
        $this->date = $date ?? new \DateTime('yesterday');
    }

    public function handle()
    {
        $providerType = config('payment.provider', 'mock');
        
        $provider = match($providerType) {
            'midtrans' => new QrisProviderMidtrans(),
            'mock' => new QrisProviderMock(),
            default => new QrisProviderMock(),
        };
        
        try {
            $settlements = $provider->fetchSettlement($this->date);
            
            $count = 0;
            
            foreach ($settlements as $settlementData) {
                $payment = Payment::where('provider_trx_id', $settlementData['trx_id'])->first();
                
                $settlement = Settlement::create([
                    'provider_trx_id' => $settlementData['trx_id'],
                    'payment_id' => $payment?->id,
                    'amount' => $settlementData['amount'],
                    'fee' => $settlementData['fee'] ?? 0,
                    'net_amount' => $settlementData['net_amount'] ?? ($settlementData['amount'] - ($settlementData['fee'] ?? 0)),
                    'settlement_date' => $settlementData['settlement_date'],
                    'file_id' => $settlementData['file_id'] ?? null,
                    'reconciled' => false,
                ]);
                
                if ($payment) {
                    PaymentLog::create([
                        'payment_id' => $payment->id,
                        'event' => 'RECONCILE',
                        'payload' => [
                            'settlement_id' => $settlement->id,
                            'settlement_date' => $this->date->format('Y-m-d'),
                        ],
                    ]);
                    
                    $settlement->markAsReconciled();
                    $count++;
                }
            }
            
            Log::info('Daily reconciliation completed', [
                'date' => $this->date->format('Y-m-d'),
                'settlements_processed' => count($settlements),
                'reconciled_count' => $count,
            ]);
            
            return $count;
            
        } catch (\Exception $e) {
            Log::error('Daily reconciliation failed', [
                'date' => $this->date->format('Y-m-d'),
                'error' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }
}
