<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    // Create Token Function/Method
    public static function createTokenForUserLogin($userEmail): string
    {
        $key = env('JWT_KEY'); // secret key that create in .env file
        $payload = [
            'iss' => 'laravel_token', // token issue name
            'iat' => time(), // token create time
            'exp' => time() + 60 * 60, // token expiry time
            'userEmail' => $userEmail //token create for why user
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }
    // Create Token Function/Method
    public static function createTokenForForgetPassword($userEmail): string
    {
        $key = env('JWT_KEY'); // secret key that create in .env file
        $payload = [
            'iss' => 'laravel_token', // token issue name
            'iat' => time(), // token create time
            'exp' => time() + 60 * 5, // token expiry time
            'userEmail' => $userEmail //token create for why user
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }
    // Verify Token Function/Method
    public static function verifyToken($token): string
    {
        try {
            $key = env('JWT_KEY');  // secret key that create in .env file
            $decode = JWT::decode($token, new Key($key, 'HS256'));
            $userEmail = $decode->userEmail;
            return $userEmail;
        } catch (Exception $e) {
            return 'unauthorized';
        }
    }
}
