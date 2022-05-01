<?php

namespace App\Controllers;
use \Firebase\JWT\JWT;

class LoginController 
{
    public function login($request){
        $issueTime = time(); 
        $token = [
            "iss" => $_ENV['Issuer'],
            "aud" => $_ENV['Audience'],
            "iat" => $issueTime,
            "nbf" => $issueTime + 10,
            "exp" => $issueTime + 3600,
            "data" => [
                "username" => $request
            ]
        ];

        $jwt = JWT::encode($token, $_ENV['SECRET_KEY'], 'HS256');
        return [
            'code' => 200,
            'data' => json_encode(["message" => "Successful login", "jwt" => $jwt])
        ];
    }
}