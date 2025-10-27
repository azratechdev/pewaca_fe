<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment\Payment;
use App\Models\Payment\PaymentLog;
use App\Services\Qris\QrisProvider;
use App\Services\Qris\QrisProviderMock;
use App\Services\Qris\QrisProviderMidtrans;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
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
    
    public function create(Request $request)
    {
        try {
            $paymentService = app(\App\Services\Payment\PaymentService::class);
            
            $data = $request->all();
            $data['idempotency_key'] = $request->header('Idempotency-Key') ?? Str::uuid()->toString();
            
            $result = $paymentService->createPayment($data);
            
            $isNew = $result['_is_new'] ?? false;
            unset($result['_is_new']);
            
            return response()->json($result, $isNew ? 201 : 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'Idempotency key conflict')) {
                return response()->json([
                    'error' => 'Idempotency key conflict',
                    'message' => $e->getMessage(),
                ], 409);
            }
            
            Log::error('Payment creation failed', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);
            
            return response()->json([
                'error' => 'Payment creation failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    
    private function createPaymentOld(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|string|max:100',
                'amount' => 'required|numeric|min:1',
                'callback_url' => 'nullable|url',
                'metadata' => 'nullable|array',
            ]);
            
            $idempotencyKey = $request->header('Idempotency-Key') ?? Str::uuid()->toString();
            
            $paymentByIdempotency = Payment::where('idempotency_key', $idempotencyKey)->first();
            if ($paymentByIdempotency) {
                if ($paymentByIdempotency->order_id !== $validated['order_id']) {
                    return response()->json([
                        'error' => 'Idempotency key conflict',
                        'message' => 'This idempotency key is already used for a different order',
                    ], 409);
                }
                
                if ($paymentByIdempotency->isPaid() || $paymentByIdempotency->isPending()) {
                    return response()->json([
                        'payment_id' => $paymentByIdempotency->id,
                        'status' => $paymentByIdempotency->status,
                        'qr_string' => $paymentByIdempotency->qris_payload,
                        'expires_at' => $paymentByIdempotency->expires_at?->toIso8601String(),
                        'provider_trx_id' => $paymentByIdempotency->provider_trx_id,
                    ], 200);
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
                        return response()->json([
                            'payment_id' => $paymentByOrderId->id,
                            'status' => $paymentByOrderId->status,
                            'qr_string' => $paymentByOrderId->qris_payload,
                            'expires_at' => $paymentByOrderId->expires_at?->toIso8601String(),
                            'provider_trx_id' => $paymentByOrderId->provider_trx_id,
                        ], 200);
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
                    'event' => 'CREATED',
                    'payload' => ['provider_response' => $qrResult],
                ]);
                
                return response()->json([
                    'payment_id' => $payment->id,
                    'status' => $payment->status,
                    'qr_string' => $payment->qris_payload,
                    'expires_at' => $payment->expires_at,
                    'provider_trx_id' => $payment->provider_trx_id,
                ], 201);
                
            } catch (\Exception $e) {
                Log::error('Failed to create QR', [
                    'payment_id' => $payment->id,
                    'error' => $e->getMessage()
                ]);
                
                $payment->update(['status' => 'FAILED']);
                
                PaymentLog::create([
                    'payment_id' => $payment->id,
                    'event' => 'ERROR',
                    'payload' => ['error' => $e->getMessage()],
                ]);
                
                return response()->json([
                    'error' => 'Failed to create payment QR',
                    'message' => $e->getMessage(),
                ], 500);
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Payment creation error', ['error' => $e->getMessage()]);
            
            return response()->json([
                'error' => 'Internal server error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function show($id)
    {
        try {
            $payment = Payment::with('logs')->findOrFail($id);
            
            return response()->json([
                'payment_id' => $payment->id,
                'order_id' => $payment->order_id,
                'amount' => $payment->amount,
                'currency' => $payment->currency,
                'status' => $payment->status,
                'provider_trx_id' => $payment->provider_trx_id,
                'provider_ref_no' => $payment->provider_ref_no,
                'qr_string' => $payment->qris_payload,
                'expires_at' => $payment->expires_at?->toIso8601String(),
                'paid_at' => $payment->paid_at?->toIso8601String(),
                'metadata' => $payment->metadata,
                'created_at' => $payment->created_at->toIso8601String(),
                'updated_at' => $payment->updated_at->toIso8601String(),
            ], 200);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Payment not found',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Payment retrieval error', ['error' => $e->getMessage()]);
            
            return response()->json([
                'error' => 'Internal server error',
            ], 500);
        }
    }
}
