<?php

namespace App\Controllers;

class HomeController 
{
    public function home($request){
        return [
            'code' => 200,
            'data' => ["message" => "Homepage Test AWS Server"]
        ];
    }
}