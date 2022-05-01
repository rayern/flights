<?php

namespace App\Controllers;

class FlightController 
{
    public function __construct(){
    }

    public function createForm(){
        return template('admin', 'admin.users.create');
    }

    public function search($request){
        return ['code' => 200, 'data' => json_encode($request)];
    }
}