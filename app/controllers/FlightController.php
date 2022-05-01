<?php

namespace App\Controllers;

class FlightController 
{
    public function __construct(User $user){
    }

    public function createForm(){
        return template('admin', 'admin.users.create');
    }

    public function search($request){
        return ['code' => 200, 'data' => "Flight"];
    }
}