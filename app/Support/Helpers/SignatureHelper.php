<?php

namespace App\Support\Helpers;

class SignatureHelper
{
    public static function generate(string $data, string $secret): string
    {
        return hash_hmac('sha256', $data, $secret);
    }
    
    public static function verify(string $data, string $signature, string $secret): bool
    {
        $expectedSignature = self::generate($data, $secret);
        return hash_equals($expectedSignature, $signature);
    }
    
    public static function generateCallbackSignature(array $data, string $secret): string
    {
        ksort($data);
        $stringToSign = http_build_query($data);
        return self::generate($stringToSign, $secret);
    }
}
