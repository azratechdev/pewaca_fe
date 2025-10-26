<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment\Payment;
use App\Models\Payment\PaymentLog;
use App\Models\Payment\WebhookEvent;
use App\Services\Qris\QrisProvider;
use App\Services\Qris\QrisProviderMock;
use App\Services\Qris\QrisProviderMidtrans;
use App\Support\Helpers\SignatureHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    private QrisProvider $provider;
    
    public function __construct()
    {
        $providerType = config('payment.provider', 'mock');
        
        $this->provider = match($providerType) {
            'midtrans' => new QrisProviderMidtrans(),
            'mock' => new QrisProviderMock(),
            default => new QrisProviderMock(),
        };
    }
    
    public function handleQrisWebhook(Request $request)
    {
        try {
            $signature = $request->header('X-Signature');
            $eventId = $request->header('X-Event-Id');
            $rawBody = $request->getContent();
            
            if (!$signature) {
                return response()->json(['error' => 'Missing signature'], 401);
            }
            
            if (!$this->provider->verifyWebhookSignature($rawBody, $signature)) {
                Log::warning('Webhook signature verification failed', [
                    'signature' => $signature,
                    'event_id' => $eventId,
                ]);
                
                return response()->json(['error' => 'Invalid signature'], 401);
            }
            
            $existingEvent = WebhookEvent::where('event_id', $eventId)->first();
            if ($existingEvent) {
                Log::info('Duplicate webhook event', ['event_id' => $eventId]);
                
                return response()->json([
                    'message' => 'Event already processed',
                    'status' => $existingEvent->status,
                ], 200);
            }
            
            $webhookEvent = WebhookEvent::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'provider' => 'qris_' . config('payment.provider', 'mock'),
                'event_id' => $eventId ?? \Illuminate\Support\Str::uuid(),
                'payload' => $request->all(),
                'status' => 'PENDING',
            ]);
            
            try {
                $data = $this->provider->parseWebhook($request);
                
                if (!$data['trx_id']) {
                    throw new \Exception('Missing trx_id in webhook payload');
                }
                
                $payment = Payment::where('provider_trx_id', $data['trx_id'])->first();
                
                if (!$payment) {
                    Log::warning('Payment not found for webhook', [
                        'trx_id' => $data['trx_id'],
                        'event_id' => $eventId,
                    ]);
                    
                    $webhookEvent->markAsFailed('Payment not found');
                    
                    return response()->json(['error' => 'Payment not found'], 404);
                }
                
                if ($data['amount'] != $payment->amount) {
                    Log::error('Amount mismatch in webhook', [
                        'expected' => $payment->amount,
                        'received' => $data['amount'],
                        'payment_id' => $payment->id,
                    ]);
                    
                    $webhookEvent->markAsFailed('Amount mismatch');
                    
                    return response()->json(['error' => 'Amount mismatch'], 400);
                }
                
                if ($payment->isPaid()) {
                    Log::info('Payment already paid', ['payment_id' => $payment->id]);
                    
                    $webhookEvent->markAsProcessed();
                    
                    return response()->json([
                        'message' => 'Payment already processed',
                        'payment_id' => $payment->id,
                    ], 200);
                }
                
                if ($data['status'] === 'SUCCESS') {
                    $payment->update([
                        'status' => 'PAID',
                        'paid_at' => now(),
                        'provider_ref_no' => $data['ref_no'] ?? null,
                    ]);
                    
                    PaymentLog::create([
                        'payment_id' => $payment->id,
                        'event' => 'WEBHOOK_SUCCESS',
                        'payload' => $data,
                    ]);
                    
                    $webhookEvent->markAsProcessed();
                    
                    if ($payment->callback_url) {
                        $this->sendCallback($payment);
                    }
                    
                    return response()->json([
                        'message' => 'Payment processed successfully',
                        'payment_id' => $payment->id,
                        'status' => $payment->status,
                    ], 200);
                    
                } else {
                    $payment->update(['status' => 'FAILED']);
                    
                    PaymentLog::create([
                        'payment_id' => $payment->id,
                        'event' => 'ERROR',
                        'payload' => ['webhook_data' => $data, 'reason' => 'Payment failed'],
                    ]);
                    
                    $webhookEvent->markAsFailed('Payment status: ' . $data['status']);
                    
                    return response()->json([
                        'message' => 'Payment failed',
                        'status' => $data['status'],
                    ], 200);
                }
                
            } catch (\Exception $e) {
                Log::error('Webhook processing error', [
                    'error' => $e->getMessage(),
                    'event_id' => $eventId,
                ]);
                
                $webhookEvent->markAsFailed($e->getMessage());
                
                return response()->json([
                    'error' => 'Webhook processing failed',
                    'message' => $e->getMessage(),
                ], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('Webhook handler error', ['error' => $e->getMessage()]);
            
            return response()->json([
                'error' => 'Internal server error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    
    private function sendCallback(Payment $payment): void
    {
        try {
            $callbackData = [
                'payment_id' => $payment->id,
                'order_id' => $payment->order_id,
                'status' => $payment->status,
                'amount' => $payment->amount,
                'paid_at' => $payment->paid_at?->toIso8601String(),
            ];
            
            $signature = SignatureHelper::generateCallbackSignature(
                $callbackData,
                config('payment.callback_signing_key')
            );
            
            Http::withHeaders([
                'X-Callback-Signature' => $signature,
                'Content-Type' => 'application/json',
            ])->post($payment->callback_url, $callbackData);
            
            Log::info('Callback sent', [
                'payment_id' => $payment->id,
                'callback_url' => $payment->callback_url,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Callback sending failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
