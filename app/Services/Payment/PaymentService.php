<?php

namespace App\Services\Payment;

use App\Models\Payment\Payment;
use App\Models\Payment\PaymentLog;
use App\Services\Qris\QrisProvider;
use App\Services\Qris\QrisProviderMock;
use App\Services\Qris\QrisProviderMidtrans;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PaymentService
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
    
    public function createPayment(array $data): array
    {
        $validator = Validator::make($data, [
            'order_id' => 'required|string|max:100',
            'amount' => 'required|numeric|min:1',
            'callback_url' => 'nullable|url',
            'metadata' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        $idempotencyKey = $data['idempotency_key'] ?? Str::uuid()->toString();
        
        $paymentByIdempotency = Payment::where('idempotency_key', $idempotencyKey)->first();
        if ($paymentByIdempotency) {
            if ($paymentByIdempotency->order_id !== $validated['order_id']) {
                throw new \Exception('Idempotency key conflict - already used for different order');
            }
            
            if ($paymentByIdempotency->isPaid() || $paymentByIdempotency->isPending()) {
                return [
                    'payment_id' => $paymentByIdempotency->id,
                    'status' => $paymentByIdempotency->status,
                    'qr_string' => $paymentByIdempotency->qris_payload,
                    'expires_at' => $paymentByIdempotency->expires_at?->toIso8601String(),
                    'provider_trx_id' => $paymentByIdempotency->provider_trx_id,
                    '_is_new' => false,
                ];
            }
            
            $payment = $paymentByIdempotency;
            $payment->update([
                'amount' => $validated['amount'],
                'status' => 'CREATED',
                'callback_url' => $validated['callback_url'] ?? null,
                'metadata' => $validated['metadata'] ?? null,
                'qris_payload' => null,
                'provider_trx_id' => null,
                'provider_ref_no' => null,
                'expires_at' => null,
                'paid_at' => null,
            ]);
        } else {
            $paymentByOrderId = Payment::where('order_id', $validated['order_id'])->first();
            
            if ($paymentByOrderId) {
                if ($paymentByOrderId->isPaid() || $paymentByOrderId->isPending()) {
                    return [
                        'payment_id' => $paymentByOrderId->id,
                        'status' => $paymentByOrderId->status,
                        'qr_string' => $paymentByOrderId->qris_payload,
                        'expires_at' => $paymentByOrderId->expires_at?->toIso8601String(),
                        'provider_trx_id' => $paymentByOrderId->provider_trx_id,
                        '_is_new' => false,
                    ];
                }
                
                $payment = $paymentByOrderId;
                $payment->update([
                    'amount' => $validated['amount'],
                    'status' => 'CREATED',
                    'callback_url' => $validated['callback_url'] ?? null,
                    'metadata' => $validated['metadata'] ?? null,
                    'idempotency_key' => $idempotencyKey,
                    'qris_payload' => null,
                    'provider_trx_id' => null,
                    'provider_ref_no' => null,
                    'expires_at' => null,
                    'paid_at' => null,
                ]);
            } else {
                $payment = Payment::create([
                    'id' => Str::uuid(),
                    'order_id' => $validated['order_id'],
                    'amount' => $validated['amount'],
                    'currency' => 'IDR',
                    'status' => 'CREATED',
                    'callback_url' => $validated['callback_url'] ?? null,
                    'metadata' => $validated['metadata'] ?? null,
                    'idempotency_key' => $idempotencyKey,
                ]);
            }
        }
        
        PaymentLog::create([
            'payment_id' => $payment->id,
            'event' => 'CREATED',
            'payload' => ['request' => $validated],
        ]);
        
        try {
            $qrResult = $this->provider->createDynamicQR($payment);
            
            $payment->update([
                'status' => 'PENDING',
                'qris_payload' => $qrResult['qr_string'],
                'provider_trx_id' => $qrResult['trx_id'],
                'expires_at' => $qrResult['expires_at'],
            ]);
            
            PaymentLog::create([
                'payment_id' => $payment->id,
                'event' => 'QR_GENERATED',
                'payload' => $qrResult,
            ]);
            
            return [
                'payment_id' => $payment->id,
                'status' => $payment->status,
                'qr_string' => $payment->qris_payload,
                'expires_at' => $payment->expires_at->toIso8601String(),
                'provider_trx_id' => $payment->provider_trx_id,
                '_is_new' => true,
            ];
            
        } catch (\Exception $e) {
            Log::error('QR generation failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);
            
            $payment->update(['status' => 'FAILED']);
            
            PaymentLog::create([
                'payment_id' => $payment->id,
                'event' => 'QR_GENERATION_FAILED',
                'payload' => ['error' => $e->getMessage()],
            ]);
            
            throw new \Exception('Failed to generate QR code: ' . $e->getMessage());
        }
    }
}
