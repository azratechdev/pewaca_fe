<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OneSignalService
{
    protected $appId;
    protected $restApiKey;
    protected $apiUrl = 'https://onesignal.com/api/v1';

    public function __construct()
    {
        $this->appId = config('services.onesignal.app_id');
        $this->restApiKey = config('services.onesignal.rest_api_key');
    }

    /**
     * Send notification to specific user by external user ID
     */
    public function sendToUser($userId, $title, $message, $data = [])
    {
        if (empty($this->appId) || empty($this->restApiKey)) {
            Log::warning('OneSignal not configured properly');
            return false;
        }

        try {
            $payload = [
                'app_id' => $this->appId,
                'include_external_user_ids' => [$userId],
                'headings' => ['en' => $title],
                'contents' => ['en' => $message],
                'data' => $data,
                'web_url' => $data['url'] ?? null,
            ];

            Log::info('=== ONESIGNAL SEND NOTIFICATION ===');
            Log::info('Payload:', $payload);

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $this->restApiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/notifications', $payload);

            $result = $response->json();
            
            Log::info('OneSignal Response Status:', ['status' => $response->status()]);
            Log::info('OneSignal Response:', $result);

            return $response->successful() ? $result : false;
        } catch (\Exception $e) {
            Log::error('OneSignal Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Send notification to all users
     */
    public function sendToAll($title, $message, $data = [])
    {
        if (empty($this->appId) || empty($this->restApiKey)) {
            Log::warning('OneSignal not configured properly');
            return false;
        }

        try {
            $payload = [
                'app_id' => $this->appId,
                'included_segments' => ['All'],
                'headings' => ['en' => $title],
                'contents' => ['en' => $message],
                'data' => $data,
                'web_url' => $data['url'] ?? null,
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $this->restApiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/notifications', $payload);

            return $response->successful() ? $response->json() : false;
        } catch (\Exception $e) {
            Log::error('OneSignal Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Send notification to users by filter
     */
    public function sendToSegment($segment, $title, $message, $data = [])
    {
        if (empty($this->appId) || empty($this->restApiKey)) {
            Log::warning('OneSignal not configured properly');
            return false;
        }

        try {
            $payload = [
                'app_id' => $this->appId,
                'included_segments' => [$segment],
                'headings' => ['en' => $title],
                'contents' => ['en' => $message],
                'data' => $data,
                'web_url' => $data['url'] ?? null,
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $this->restApiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/notifications', $payload);

            return $response->successful() ? $response->json() : false;
        } catch (\Exception $e) {
            Log::error('OneSignal Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Send notification for payment confirmation
     */
    public function sendPaymentNotification($userId, $tagihanData)
    {
        $title = 'Pembayaran Sedang Diproses';
        $message = 'Bukti pembayaran untuk ' . ($tagihanData['tagihan_name'] ?? 'tagihan') . 
                   ' sebesar Rp ' . number_format($tagihanData['amount'] ?? 0, 0, ',', '.') . 
                   ' telah diterima dan sedang diverifikasi.';
        
        $data = [
            'type' => 'payment_confirmation',
            'tagihan_id' => $tagihanData['tagihan_id'] ?? null,
            'url' => route('pembayaran.detail_bukti', ['id' => $tagihanData['tagihan_id'] ?? '']),
        ];

        return $this->sendToUser($userId, $title, $message, $data);
    }

    /**
     * Send notification for payment approval
     */
    public function sendPaymentApprovalNotification($userId, $tagihanData)
    {
        $title = 'Pembayaran Disetujui';
        $message = 'Pembayaran untuk ' . ($tagihanData['tagihan_name'] ?? 'tagihan') . 
                   ' sebesar Rp ' . number_format($tagihanData['amount'] ?? 0, 0, ',', '.') . 
                   ' telah disetujui. Terima kasih!';
        
        $data = [
            'type' => 'payment_approved',
            'tagihan_id' => $tagihanData['tagihan_id'] ?? null,
            'url' => route('pembayaran.history'),
        ];

        return $this->sendToUser($userId, $title, $message, $data);
    }

    /**
     * Send notification for payment rejection
     */
    public function sendPaymentRejectionNotification($userId, $tagihanData, $reason = '')
    {
        $title = 'Pembayaran Ditolak';
        $message = 'Pembayaran untuk ' . ($tagihanData['tagihan_name'] ?? 'tagihan') . 
                   ' telah ditolak. ' . ($reason ? 'Alasan: ' . $reason : 'Silakan hubungi pengurus untuk informasi lebih lanjut.');
        
        $data = [
            'type' => 'payment_rejected',
            'tagihan_id' => $tagihanData['tagihan_id'] ?? null,
            'url' => route('pembayaran.list'),
        ];

        return $this->sendToUser($userId, $title, $message, $data);
    }

    /**
     * Send notification for new tagihan
     */
    public function sendNewTagihanNotification($userId, $tagihanData)
    {
        $title = 'Tagihan Baru';
        $message = 'Anda memiliki tagihan baru: ' . ($tagihanData['tagihan_name'] ?? 'tagihan') . 
                   ' sebesar Rp ' . number_format($tagihanData['amount'] ?? 0, 0, ',', '.') . 
                   '. Jatuh tempo: ' . ($tagihanData['due_date'] ?? '-');
        
        $data = [
            'type' => 'new_tagihan',
            'tagihan_id' => $tagihanData['tagihan_id'] ?? null,
            'url' => route('pembayaran.list'),
        ];

        return $this->sendToUser($userId, $title, $message, $data);
    }
}
