<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImageProxyController extends Controller
{
    public function proxy(Request $request, $path)
    {
        try {
            // Get token from session
            $token = session('token');
            
            if (!$token) {
                Log::warning('Image Proxy - No token found');
                return $this->returnDefaultImage();
            }
            
            // Construct full API URL
            $apiUrl = env('API_BASE_URL') . '/media/' . $path;
            
            Log::info('Image Proxy - Requesting: ' . $apiUrl);
            
            // Make request to API with authentication
            $response = Http::timeout(10)->withHeaders([
                'Authorization' => 'Token ' . $token,
                'Accept' => 'image/*',
            ])->get($apiUrl);
            
            if ($response->successful()) {
                $contentType = $response->header('Content-Type') ?: 'image/jpeg';
                
                Log::info('Image Proxy - Success: ' . $apiUrl);
                
                return response($response->body())
                    ->header('Content-Type', $contentType)
                    ->header('Cache-Control', 'public, max-age=3600')
                    ->header('Access-Control-Allow-Origin', '*');
            }
            
            Log::error('Image Proxy - Failed to fetch: ' . $apiUrl . ' - Status: ' . $response->status());
            
            return $this->returnDefaultImage();
            
        } catch (\Exception $e) {
            Log::error('Image Proxy Error: ' . $e->getMessage());
            return $this->returnDefaultImage();
        }
    }
    
    private function returnDefaultImage()
    {
        $defaultImagePath = public_path('assets/plugins/images/default-avatar.png');
        
        if (file_exists($defaultImagePath)) {
            return response()->file($defaultImagePath);
        }
        
        // Return a simple 1x1 transparent PNG if no default image
        $transparentPng = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==');
        
        return response($transparentPng)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}