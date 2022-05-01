<?php

namespace App\Middlewares;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Authorization
{
    public function handle(){
        
        try {
            $jwt = $_SERVER['HTTP_BEARER'];
            $decoded = JWT::decode($jwt, new Key($_ENV['SECRET_KEY'], 'HS256'));
            $authValid = true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            $authValid = false;
        }
        return $authValid;
    }
}