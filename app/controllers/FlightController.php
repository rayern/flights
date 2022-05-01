<?php

namespace App\Controllers;
use \Firebase\JWT\JWT;

class FlightController 
{
    public function search($request){
        try {
            $jwt = $_SERVER['HTTP_BEARER'];
            echo json_encode([$jwt, $_ENV['SECRET_KEY'], 'HS256']);
            $decoded = JWT::decode($jwt, $_ENV['SECRET_KEY'], 'HS256');
            $response = ['code' => 200, 'data' => json_encode([$request, $decoded])];
        } catch (\Exception $e) {
            $response = ['code' => '401', 'data' => json_encode(['message' => $e->getMessage()])];
        }
        return $response;
    }
}