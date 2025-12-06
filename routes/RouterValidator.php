<?php

namespace Routes;

use Routes\Router;
use Routes\RouteHelper;
use Src\Exceptions\RouterValidationException;

class RouterValidator{

    private static int $httpResponseCode;

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
            http_response_code(static::$httpResponseCode);
            die(static::$httpResponseCode . ": " . $ex->getMessage());
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
                $this->router->url=RouteHelper::cutValueFromUrl($this->router->url);
                if($this->router->url == $path)
                {
                    return;
                }
                $this->url_value=null;
            }
        }

        static::$httpResponseCode=404;
        throw new RouterValidationException("Page not found.");
    }

    private function handleHttpMethod()
    {

    }

    private function handleUrlValue()
    {

    }

}