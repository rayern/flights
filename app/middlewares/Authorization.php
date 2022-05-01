<?php

namespace App\Middlewares;
use \Firebase\JWT\JWT;

class Authorization
{
    public function handle(){
        
        try {
            $jwt = $_SERVER['HTTP_BEARER'];
            $decoded = JWT::decode($jwt, $_ENV['SECRET_KEY'], 'HS256');
            $authValid = true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            $authValid = false;
        }
        return $authValid;
    }
}