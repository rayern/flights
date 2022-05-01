<?php

namespace App;
use App\Middlewares;
use App\Controllers;
use App\Controllers\FlightController;

class Server{

    public function handle($route)
    {
        try {
            $routeData = $this->dispatchRouter($route);
            $this->handleMiddlewares($routeData);
            $response = $this->loadController($routeData);
            http_response_code($response['code']);
            echo $response['data'];
        } catch (\Exception $e) {
            http_response_code($e->getCode());
            echo $e->getMessage();
        } 
    }

    public function dispatchRouter($route){
        $apiRoutes = include PROJECT_PATH."/routes/api.php";
        if($apiRoutes[$route]){
            return $apiRoutes[$route];
        }
        else{
            $webRoutes = include PROJECT_PATH."/routes/web.php";
            if($webRoutes[$route]){
                return $webRoutes[$route];
            }
            else{
                throw new \Exception("Path not found", 404);
            }
        }
    }

    public function handleMiddlewares($routeData){
        if(isset($routeData['middleware'])){
            $className = 'App\\Middlewares\\' . $routeData['middleware'];
            $middleware = new $className();
            $response = $middleware->handle();
            if(!$response){
                throw new \Exception("Unauthorized", 401);
            }
        }
    }

    public function loadController($routeData){
        $type = $_SERVER['REQUEST_METHOD'];
        if(isset($routeData[$type])){
            $routeParams = explode("@", $routeData[$type]);
            $className = 'App\\Controllers\\' . $routeParams[0];
            $controller = new $className();
            return $controller->{$routeParams[1]}($_POST);
        }
        else{
            throw new \Exception("Route not configured", 404);
        }
    }
}