<?php

namespace App\Controllers;
use \Firebase\JWT\JWT;
use App\Models\Flight;
use App\Models\User;

class UserController 
{
    public function login($request){
        $user = new User;
        $user->username = $request['username'];
        $user->password = $request['password'];
        if($user->login()){
            $issueTime = time(); 
            $token = [
                "iss" => $_ENV['Issuer'],
                "aud" => $_ENV['Audience'],
                "iat" => $issueTime,
                "nbf" => $issueTime + 10,
                "exp" => $issueTime + 3600,
                "data" => [
                    "username" => $request['username']
                ]
            ];
            $jwt = JWT::encode($token, $_ENV['SECRET_KEY'], 'HS256');
            $response['jwt']  = $jwt;
            $response['message']  = "Login success";
        }
        else{
            $response['message'] = "Login failure. Please check the username and password and try again.";
        }
        return [
            'code' => 200,
            'data' => $response
        ];
    }
    public function register($request){
        $validRequest = true;
        if(!$request['username']){
            $message = "Username is required. Please check and try again";
            $validRequest = false;
        }
        if(!$request['password']){
            $message = "Password is required. Please check and try again";
            $validRequest = false;
        }
        if(isset($request['email']) && filter_var($request['email'], FILTER_VALIDATE_EMAIL) === false){
            $message = "You have entered an invalid email. Please check and try again";
            $validRequest = false;
        }
        if($validRequest){
            $user = new User;
            $user->firstName = $request['firstName'];
            $user->lastName = $request['lastName'];
            $user->email = $request['email'];
            $user->username = $request['username'];
            $user->password = $request['password'];
            $response = $user->register();
            $validRequest = $response['success'];
            $message = $response['message'];
        }
        return [
            'code' => 200,
            'success' => $validRequest,
            'data' => $message
        ];
    }
}