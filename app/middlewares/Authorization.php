<?php

namespace App\Middlewares;

class Authorization
{
    public function handle()
    {
        Log::info(__METHOD__);
        Auth::check();
    }
}