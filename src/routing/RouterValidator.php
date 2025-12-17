<?php

namespace Src\Routing;

use Src\Routing\Router;
use Src\Routing\RouteData;
use Src\Routing\RouteHelper;
use Src\Exceptions\RouterValidationException;

class RouterValidator{

    public function __construct(
        private RouteData $route
    ){}

    public static function validate(RouteData $route):void
    {
        try
        {
            $routerValidator=new RouterValidator($route);
            $routerValidator->handleError404(); 
            $routerValidator->handleHttpMethod();
        }
        catch(RouterValidationException $ex)
        {
            http_response_code($ex->getCode());
            die($ex->getCode() . ": " . $ex->getMessage());
        }
        catch(\Exception $ex)
        {
            die($ex->getMessage());
        }
    }    

    private function handleError404():void
    {
        foreach(Route::$routes as $route)
        {
            if($this->route->url == $route->url)
                return;
        }
        throw new RouterValidationException("Page not found.", 404);
    }

    private function handleHttpMethod():void
    {
        $method=$this->route->method;
        if(isset($_SERVER["REQUEST_METHOD"]) && $method != "view")
        {
            if($method != strtolower($_SERVER["REQUEST_METHOD"]) )
            {
                throw new RouterValidationException("Wrong http method.", 405);
            }
        }
    }
}