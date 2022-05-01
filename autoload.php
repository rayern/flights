<?php
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function loadLibs($class){
    $filename = PROJECT_PATH .'/'. str_replace("\\", '/', $class) . ".php";
    echo __LINE__.":".$filename."<hr>";
    if (file_exists($filename)) {
        echo __LINE__."<hr>";
        include($filename);
        if (class_exists($class)) {
            echo __LINE__."<hr>";
            return TRUE;
        }
    }
    return FALSE;
}

spl_autoload_register('loadLibs');