<?php

namespace App;
use App\Middlewares;
use App\Controllers;

class Server{

    public function handle($route)
    {
        try {
            $routeData = $this->dispatchRouter($route);
            $this->handleMiddlewares($routeData);
            $response = $this->loadController($routeData);
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'data' => $e->getMessage()
            ];
        } finally {
            http_response_code($response['code']);
            echo $response['data'];
        }
    }

    public function dispatchRouter($route){
        $apiRoutes = include __DIR__."/../routes/api.php";
        if($apiRoutes[$route]){
            return $apiRoutes[$route];
        }
        else{
            $webRoutes = include __DIR__."/../routes/web.php";
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
            $middlewares = include __DIR__."/../config/middlewares.php";
            if($middlewares[$routeData['middleware']]){
                $middleware = new $middlewares[$routeData['middleware']]();
                $response = $middleware->handle();
                if(!$response){
                    throw new \Exception("Unauthorized", 401);
                }
            }
        }
    }

    public function loadController($routeData){
        $type = $_SERVER['REQUEST_METHOD'];
        if(isset($routeData[$type])){
            $routeParams = explode("@", $routeData[$type]);
            $controller = new $routeParams[0]();
            return $controller->{$routeParams[1]}($_REQUEST);
        }
        else{
            throw new \Exception("Route not configured", 404);
        }
    }
}