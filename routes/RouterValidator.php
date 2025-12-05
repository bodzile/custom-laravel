<?php

namespace Routes;

use Routes\RouteHelper;

class RouterValidator{

    public static function validate(string $url):void
    {
        static::handleError404($url);   
    }

    private static function handleError404($url):void
    {
        foreach(Route::$links as $path => $param)
        {
            if($url == $path)
            {
                return;
            }
            
            if(isset($param["url_value"]))
            {
                $url=RouteHelper::cutValueFromUrl($url);
                if($url == $path)
                {
                    return;
                }
                $url_value=null;
            }
        }

        http_response_code(404);
        die("404 Error: Page not found");
    }


    // private static function handleError404($url):void
    // {
    //     foreach(Route::$links as $path => $param)
    //     {
    //         if($this->url == $path)
    //         {
    //             return;
    //         }
            
    //         if(isset($param["url_value"]))
    //         {
    //             $this->url_value=RouteHelper::getValueFromUrl($this->url);
    //             $this->url=RouteHelper::cutValueFromUrl($this->url);
    //             if($this->url == $path)
    //             {
    //                 return;
    //             }
    //             $this->url.=$this->url_value;
    //             $this->url_value=null;
    //         }
    //     }

    //     http_response_code(404);
    //     die("404 Error: Page not found");
    // }


}