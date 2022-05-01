<?php

namespace App\Controllers\FlightController;

use App\Controllers\Controller as BaseController;

class FlightController extends BaseController
{
    private $user;
    private $log;
    private $template;

    /**
    * User Controller construct
    *
    * @param User $user User
    */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
        $this->log = new Log();
        $this->template = new Template();
    }

    /**
    * Created User Form
    *
    * @return void
    */
    public function createForm()
    {
        return template('admin', 'admin.users.create');
    }
}