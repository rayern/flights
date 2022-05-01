<?php

namespace App\Controllers;
use App\Models\Flight;

class FlightController 
{
    public function search($request){
        $flightsData = Flight::fetch(); 

        return ['code' => 200, 'data' => json_encode([$request,$flightsData])];;
    }
}