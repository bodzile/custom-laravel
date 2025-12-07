<?php

namespace Routes;

use Routes\Router;
use Routes\RouteHelper;
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

    private function handleHttpMethod()
    {

    }

    private function handleUrlValue()
    {

    }

}