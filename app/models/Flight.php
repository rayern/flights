<?php

namespace App\Models;

class Flight{
    const TABLE = 'flights';
    public static function fetchJSON(){
        return json_decode(file_get_contents(PROJECT_PATH.'/storage/json/data.json'), true);
    }

    public static function fetch($filters){
        $db = new \Storage\Database();
        $db->table(self::TABLE)->select('*');
        if($filters['origin']){
            $db->where('origin', $filters['origin']);
        }
        if($filters['destination']){
            $db->where('destination', $filters['destination']);
        }
        if($filters['availableSeats']){
            $db->where('availableSeats', $filters['availableSeats'], '>');
        }
        if($filters['departure']){
            $db->where("date_format(departure,'%Y-%m-%d')", $filters['departure'],'=','departure');
        }
        $flights = $db->get();
        return $flights;
    }

    public static function store(){
        $flights = self::fetch();
        $db = new \Storage\Database();
        foreach($flights as $flight){
            $departureDate = new \DateTime($flight['departure']);
            $arrivalDate = new \DateTime($flight['arrival']);
            $flight['departure'] = $departureDate->format('Y-m-d H:i:s');
            $flight['arrival'] = $arrivalDate->format('Y-m-d H:i:s');
            $flight['operationalDays'] = json_encode($flight['operationalDays']);
            $db->table('flights')->insert($flight);
        }
        
    }
    

}