<?php
define("PROJECT_PATH", __DIR__);
require PROJECT_PATH . '/vendor/autoload.php';
use App\Server;
use Dotenv\Dotenv;
var_dump($_POST);
try {
    $route = $_SERVER['PATH_INFO'] ?? "";
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $server = new Server();
    $server->handle($route);
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>