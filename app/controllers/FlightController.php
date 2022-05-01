<?php

namespace App\Controllers;

class FlightController 
{
    public function search($request){
        return ['code' => 200, 'data' => json_encode([$request])];;
    }
}