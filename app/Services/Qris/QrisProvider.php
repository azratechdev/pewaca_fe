<?php

namespace App\Services\Qris;

use App\Models\Payment\Payment;
use Illuminate\Http\Request;

interface QrisProvider
{
    public function createDynamicQR(Payment $payment): array;
    
    public function parseWebhook(Request $request): array;
    
    public function fetchSettlement(\DateTime $date): array;
    
    public function verifyWebhookSignature(string $rawBody, string $signature): bool;
}
