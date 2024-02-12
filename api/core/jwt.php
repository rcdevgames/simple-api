<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHelper {
    private static $key = JWT_SECRET;

    // Expired in hour
    public static function generateToken($data, $expired_minutes=30) { 
        $issuedAt = time();
        $expirationTime = $issuedAt + (60*$expired_minutes); // Token expires in 1 hour
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data
        );
        return JWT::encode($payload, self::$key, 'HS256');
    }

    public static function verifyToken($token) {
        try {
            $decoded = JWT::decode($token, new Key(self::$key, 'HS256'));
            return $decoded->data;
        } catch (Exception $e) {
            return false;
        }
    }
}
