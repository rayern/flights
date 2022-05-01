<?php

function loadLibs($class){
    require_once __DIR__.$className.".php";
}

spl_autoload_register('loadLibs');