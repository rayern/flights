<?php

namespace App\Models;

class Flight{
    public static function fetch(){
        return json_decode(file_get_contents(PROJECT_PATH.'/storage/json/data.json'), true);
    }
}