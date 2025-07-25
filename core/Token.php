<?php

namespace Core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token
{
// todo get it from config file
    const JWT_SECRET = 'change_this_secret_to_something_random!';

    public function generate($email)
    {
        $payload = [
            'iss' => 'localhost',   // Issuer
            'aud' => 'localhost',   // Audience
            'iat' => time(),        // Issued at
            'exp' => time() + 3600 * 24 * 30, // Expiry (1 month)
            'sub' => $email         // Subject
        ];
        return JWT::encode($payload, static::JWT_SECRET, 'HS256');
    }

    public function verify(string $token)
    {
        return JWT::decode($token, new Key(static::JWT_SECRET, 'HS256'));
    }

    public function extractTokenFromHeader(): string|null
    {
        $headers = getallheaders();
        $token = array_find($headers, fn($value) => stripos($value, 'Bearer') > -1);

        if (!$token) {
            return null;
        }

        if (preg_match('/Bearer\s(\S+)/i', $token, $matches)) {
            return $matches[1];
        }
        return null;
    }

}