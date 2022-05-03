<?php

namespace App\Controllers;
use App\Models\Flight;

class FlightController 
{
    public function search($request){
        $validRequest = true;
        $resultData = [];
        $filters = [];
        if($request['origin']){
            $filters['origin'] = trim($request['origin']);
        }
        if($request['destination']){
            $filters['destination'] = trim($request['destination']);
        }
        if($request['passengers']){
            $filters['availableSeats'] = $request['passengers'];
        }
        if($request['departure'] && strtotime($request['departure'])){
            $filters['departure'] = $request['departure'];
        }
        if(count($filters) > 0){
            $flights = Flight::fetch($filters);
            if(count($flights) > 0){
                $message = 'Success. Found '.count($flights).' records';
            }
            else{
                $message = 'No records found';
            }
        }
        else{
            $message = 'Please enter atleast one filter and try again';
            $validRequest = false;
        }
       
        return [
            'code' => 200, 
            'success' => $validRequest,
            'data' => [
                'message' => $message,
                'data' => $flights
            ]
        ];
    }
    
}