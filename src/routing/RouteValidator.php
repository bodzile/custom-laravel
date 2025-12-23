<?php

namespace Src\Routing;

use Src\Routing\Route;
use Src\Exceptions\RouteAlreadyExistException;
use Src\Exceptions\RouteNameAlreadyExistException;
use Src\Exceptions\RouteDataNotSetException;
use Src\Exceptions\MiddlewareNotFoundException;
use Src\Exceptions\ViewNotFoundException;

use Exception;
use Throwable;

class RouteValidator{

    public function __construct(
        private RouteData $route
    ){}

    public static function validate(RouteData $route):void
    {
        $validator=new RouteValidator($route);
        $validator->checkRoute();
        $validator->checkRequiredRouteData();   
        $validator->checkMiddlewaresExist();
    }

    private function checkRoute():void
    {
        if(count(Route::$routes) < 1)
            return;

        foreach(Route::$routes as $route)
        {
            if($this->route->url == $route->url)
                throw new RouteAlreadyExistException;
            if( !empty($route->name) && ($this->route->name == $route->name) )
                throw new RouteNameAlreadyExistException;       
        }
    }

    private function checkRequiredRouteData():void 
    {
        $required=[
            "url", "method"
        ];
        foreach($required as $property)
        {
            if(empty($this->route->$property))
                throw new RouteDataNotSetException();
        }
    }

    private function checkMiddlewaresExist():void
    {   
        foreach($this->route->middlewares as $middleware)
        {
            if(!class_exists($middleware))
                throw new MiddlewareNotFoundException();
        }
    }

    private function checkViewExist():void 
    {
        if(!empty($this->route->view) && !file_exists(view($this->route->view)))
            throw new ViewNotFoundException;

    }

}