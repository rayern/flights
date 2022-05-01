<?php

namespace App\Controllers;

use App\Controllers\Controller as BaseController;

class FlightController extends BaseController
{
    private $user;
    private $log;
    private $template;

    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
        $this->log = new Log();
        $this->template = new Template();
    }

    public function createForm(){
        return template('admin', 'admin.users.create');
    }

    public function search($request){
        
    }
}