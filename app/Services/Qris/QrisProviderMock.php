<?php

namespace App\Services\Qris;

use App\Models\Payment\Payment;
use App\Support\Helpers\SignatureHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QrisProviderMock implements QrisProvider
{
    private string $webhookSecret;
    
    public function __construct()
    {
        $this->webhookSecret = config('payment.webhook_secret', 'mock_secret_key_12345');
    }
    
    public function createDynamicQR(Payment $payment): array
    {
        $qrString = $this->generateMockQRCode($payment);
        $trxId = 'QRIS-MOCK-' . strtoupper(Str::random(8));
        $expiresAt = now()->addMinutes(config('payment.expire_minutes', 15));
        
        return [
            'qr_string' => $qrString,
            'trx_id' => $trxId,
            'expires_at' => $expiresAt->toIso8601String(),
        ];
    }
    
    public function parseWebhook(Request $request): array
    {
        $body = $request->all();
        
        return [
            'trx_id' => $body['trx_id'] ?? null,
            'order_id' => $body['order_id'] ?? null,
            'amount' => $body['amount'] ?? null,
            'status' => $body['status'] ?? null,
            'ref_no' => $body['ref_no'] ?? null,
            'event_id' => $request->header('X-Event-Id') ?? Str::uuid()->toString(),
        ];
    }
    
    public function fetchSettlement(\DateTime $date): array
    {
        return [
            [
                'trx_id' => 'QRIS-MOCK-SETTLED001',
                'amount' => 150000,
                'fee' => 2000,
                'net_amount' => 148000,
                'settlement_date' => $date->format('Y-m-d'),
            ],
        ];
    }
    
    public function verifyWebhookSignature(string $rawBody, string $signature): bool
    {
        $expectedSignature = \App\Support\Helpers\SignatureHelper::generate($rawBody, $this->webhookSecret);
        return hash_equals($expectedSignature, $signature);
    }
    
    private function generateMockQRCode(Payment $payment): string
    {
        $template = "00020101021226670016COM.MOCK.WWW01189360050300000898740214{order_id}0303UME51440014ID.CO.QRIS.WWW0215ID{merchant_id}0303UME52045811530336054{amount}5802ID5913{merchant_name}6013{merchant_city}61051234062220318{trx_id}6304{crc}";
        
        return str_replace(
            ['{order_id}', '{merchant_id}', '{amount}', '{merchant_name}', '{merchant_city}', '{trx_id}', '{crc}'],
            [
                $payment->order_id,
                'MOCK123456',
                str_pad($payment->amount * 100, 12, '0', STR_PAD_LEFT),
                'PEWACA_RESIDENCE',
                'JAKARTA',
                'MOCK' . time(),
                strtoupper(substr(md5($payment->order_id), 0, 4))
            ],
            $template
        );
    }
}
