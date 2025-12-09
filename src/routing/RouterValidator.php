<?php

namespace Src\Routing;

use Src\Routing\Router;
use Src\Routing\RouteHelper;
use Src\Exceptions\RouterValidationException;

class RouterValidator{

    public function __construct(
        private Router $router
    ){}

    public static function validate(Router $router):void
    {
        try
        {
            $routerValidator=new RouterValidator($router);
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
        foreach(Route::$links as $path => $param)
        {
            if($this->router->url == $path)
            {
                return;
            }
            
            if(isset($param["url_value"]))
            {
                $url=RouteHelper::cutValueFromUrl($this->router->url);
                if($url == $path)
                {
                    return;
                }
            }
        }

        throw new RouterValidationException("Page not found.", 404);
    }

    private function handleHttpMethod():void
    {
        $method=$this->router->route->method;
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

}