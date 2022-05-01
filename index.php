<?php

require __DIR__ . '/App/autoload.php';
use App\Server;

try {
    $server = new Server();
    $server->handle($_SERVER['PATH_INFO']);
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>