<?php
define("PROJECT_PATH", __DIR__);
require PROJECT_PATH . '/vendor/autoload.php';
//require PROJECT_PATH . '/autoload.php';
use App\Server;

try {
    $server = new Server();
    $server->handle($_SERVER['PATH_INFO']);
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>