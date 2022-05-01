<?php
define("PROJECT_PATH", __DIR__);
require PROJECT_PATH . '/vendor/autoload.php';
use App\Server;
use Dotenv\Dotenv;

try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $server = new Server();
    $server->handle($_SERVER['PATH_INFO']);
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>