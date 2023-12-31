<?php


namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;

class JWTToken{
    public static function  CreateToken($userEmail) : string{
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + (60 * 60),
            'userEmail' => $userEmail
        ];

         return JWT::encode($payload, $key,'HS256');

    }

    function VerifyToken($token) : string{

        try{
            $key = env('JWT_KEY');
            $decoded = JWT::decode($token, $key,'HS256');
            return $decoded->userEmail;
        }catch(Exception $e){
            return 'unauthorized';
        
        }

    
    }

}