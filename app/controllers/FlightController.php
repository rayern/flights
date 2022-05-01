<?php

namespace App\Controllers;
use App\Models\Flight;

class FlightController 
{
    public function search($request){
        $validRequest = true;
        $resultData = [];
        if($request['origin'] && $request['destination'] && $request['passengers'] && $request['departure']){
            $flightsData = Flight::fetch(); 
            foreach((array)$flightsData as $singleFlightData){
                $departureDate = new \DateTime($singleFlightData['departure']);
                if( $singleFlightData['origin'] == $request['origin'] && 
                    $singleFlightData['destination'] == $request['destination'] &&
                    $singleFlightData['availableSeats'] >= $request['passengers'] &&
                    $departureDate->format('Y-m-d') == $request['departure']
                    ){
                        $resultData[] = $singleFlightData;
                }
            }
            $message = 'Found '.count($resultData).' records';
        }
        else{
            $message = 'Please check the request sent and try again';
            $validRequest = false;
        }
        if($validRequest == true && count($resultData) == 0){
            $message = 'No records found';
        }
        return ['code' => 200, 
            'data' => [
                'message' => $message,
                'data' => $resultData
            ]
        ];
    }
}