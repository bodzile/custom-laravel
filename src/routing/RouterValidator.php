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
            $routerValidator->handleUrlValue();
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

    private function handleUrlValue():void
    {
        //throw new RouterValidationException("Wrong type/regex for url value.", 400);
    }

    // private function routeParamUrlValid(string $url, string $route):bool
    // {
    //     if($route == $url)
    //         return false;
    //     $urlSplit=explode("/",$url);
    //     $routeSplit=explode("/",$route);
        
    //     if( (count($routeSplit)+1 == count($urlSplit)) && !empty($urlSplit[count($urlSplit)-1]) )
    //     {   
    //         for($i=0;$i<count($routeSplit);$i++)
    //         {
    //             if($urlSplit[$i] != $routeSplit[$i])
    //                 return false;
    //         }
    //         return true;
    //     }
    //     return false;
    // }

}