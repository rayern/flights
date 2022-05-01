<?php

namespace App\Middlewares;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Authorization
{
    public function handle(){
        $jwt = $_SERVER['HTTP_BEARER'];
        $decoded = JWT::decode($jwt, new Key($_ENV['SECRET_KEY'], 'HS256'));
        return true;
    }
}