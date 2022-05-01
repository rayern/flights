<?php
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function loadLibs($class){
    require_once __DIR__.'/'.str_replace('\\','/',$class).".php";
}

spl_autoload_register('loadLibs');