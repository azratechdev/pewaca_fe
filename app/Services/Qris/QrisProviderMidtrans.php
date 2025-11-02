<?php

namespace App\Services\Qris;

use App\Models\Payment\Payment;
use Illuminate\Http\Request;

class QrisProviderMidtrans implements QrisProvider
{
    private string $serverKey;
    private string $apiUrl;
    
    public function __construct()
    {
        $this->serverKey = config('payment.provider_api_key', '');
        $this->apiUrl = config('payment.provider_api_url', 'https://api.midtrans.com/v2');
    }
    
    public function createDynamicQR(Payment $payment): array
    {
        throw new \Exception('Midtrans provider not implemented yet. Use mock provider for testing.');
    }
    
    public function parseWebhook(Request $request): array
    {
        throw new \Exception('Midtrans provider not implemented yet. Use mock provider for testing.');
    }
    
    public function fetchSettlement(\DateTime $date): array
    {
        throw new \Exception('Midtrans provider not implemented yet. Use mock provider for testing.');
    }
    
    public function verifyWebhookSignature(string $rawBody, string $signature): bool
    {
        throw new \Exception('Midtrans provider not implemented yet. Use mock provider for testing.');
    }
}
