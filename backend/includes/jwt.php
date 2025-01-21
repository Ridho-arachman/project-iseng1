<?php
class JWT
{
    private static $secret_key = "your_secret_key"; // Ganti dengan kunci rahasia Anda
    private static $algorithm = "HS256"; // Algoritma hashing
    // Buat JWT
    public static function encode($payload)
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => self::$algorithm]);
        $base64Header = self::base64UrlEncode($header);
        $base64Payload = self::base64UrlEncode(json_encode($payload));
        $signature = hash_hmac('sha256', "$base64Header.$base64Payload", self::$secret_key, true);
        $base64Signature = self::base64UrlEncode($signature);
        return "$base64Header.$base64Payload.$base64Signature";
    }
    public static function decode($token)
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }
        [$header, $payload, $signature] = $parts;
        $validSignature = hash_hmac('sha256', "$header.$payload", self::$secret_key, true);
        if (self::base64UrlEncode($validSignature) !== $signature) {
            return false;
        }
        return json_decode(self::base64UrlDecode($payload), true);
    }
    private static function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    private static function base64UrlDecode($data)
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
