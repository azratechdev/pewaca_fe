<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImageHelper
{
    /**
     * Convert API image URL to proxy URL
     */
    public static function getImageUrl($apiImageUrl)
    {
        if (empty($apiImageUrl)) {
            return asset('assets/plugins/images/default-avatar.png');
        }
        
        // Extract path from API URL
        // Example: http://127.0.0.1:8000//media/profile_photos/1000135983.jpg
        // or: http://127.0.0.1:8000/media/residence_images/residence1.jpg
        $pattern = '/\/media\/(.+)/';
        
        if (preg_match($pattern, $apiImageUrl, $matches)) {
            $imagePath = $matches[1];
            return route('image.proxy', ['path' => $imagePath]);
        }
        
        return asset('assets/plugins/images/default-avatar.png');
    }
    
    /**
     * Upload file to Tencent Cloud (future implementation)
     */
    public static function uploadToTencent($file, $folder = 'uploads')
    {
        try {
            // This will be implemented when AWS SDK is installed
            // For now, return false
            Log::info('Tencent Upload - Feature not yet implemented');
            return false;
            
        } catch (\Exception $e) {
            Log::error('Tencent Upload Error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Test Tencent Cloud connection
     */
    public static function testTencentConnection()
    {
        try {
            $endpoint = env('TENCENT_ENDPOINT');
            $bucket = env('TENCENT_BUCKET');
            
            if (empty($endpoint) || empty($bucket)) {
                return [
                    'success' => false,
                    'message' => 'Tencent Cloud configuration incomplete'
                ];
            }
            
            // Simple ping test to endpoint
            $response = Http::timeout(10)->get($endpoint);
            
            return [
                'success' => true,
                'message' => 'Tencent Cloud endpoint accessible',
                'endpoint' => $endpoint,
                'bucket' => $bucket
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Tencent Cloud connection failed: ' . $e->getMessage()
            ];
        }
    }
}