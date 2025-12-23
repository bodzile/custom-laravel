<?php

namespace Src\Routing;

use Src\Routing\Router;
use Src\Routing\RouteData;
use Src\Routing\RouteHelper;
use Src\Exceptions\RouterValidationException;
use Src\Exceptions\RouterPageNotFoundException;
use Src\Exceptions\RouterWrongHttpMethodException;

class RouterValidator{

    public function __construct(
        private RouteData $route
    ){}

    public static function validate(RouteData $route):void
    {
        $routerValidator=new RouterValidator($route);
        $routerValidator->handleError404(); 
        $routerValidator->handleHttpMethod();   
    }    

    private function handleError404():void
    {
        foreach(Route::$routes as $route)
        {
            if($this->route->url == $route->url)
                return;
        }
        throw new RouterPageNotFoundException;
    }

    private function handleHttpMethod():void
    {
        $method=$this->route->method;
        if(isset($_SERVER["REQUEST_METHOD"]) && $method != "view")
        {
            if($method != strtolower($_SERVER["REQUEST_METHOD"]) )
            {
                throw new RouterWrongHttpMethodException;
            }
        }
    }
}