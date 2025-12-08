<?php

namespace Src\Routing;

use Src\Routing\Route;
use Src\Routing\RouteHelper;
use App\Http\Requests\Request;
use App\Http\Controllers\Controller;

class RouterObjectBuilder{

    public static function buildRequest():Request 
    {
        $request=new Request;
        switch($_SERVER["REQUEST_METHOD"])
        {
            case "GET":
                $request->setRequestFields($_GET); break;
            case "POST":
                $request->setRequestFields($_POST); break;
        }
        return $request;
    }

    public static function buildUrl():string 
    {
        $url = RouteHelper::extractPath($_SERVER["REQUEST_URI"]);
        if($_SERVER["REQUEST_METHOD"] == "GET")
            $url=RouteHelper::cutGetFromUrl($url);
        return $url;
    }

    public static function setUrlValue(string $url)
    {
        $url_value=null;
        if(!isset(Route::$links[$url]))
        {
            $url=RouteHelper::cutValueFromUrl($url);
            if(isset(Route::$links[$url]["url_value"]))
                $url_value=RouteHelper::getValueFromUrl($url);
        }
        
        return $url_value;
    }

    public static function buildRoute(string $url):array 
    {
        return Route::$links[$url];
    }

    public static function buildController(array $route):Controller
    {
        $namespace = (new \ReflectionClass(Controller::class))->getNamespaceName();
        $class=$namespace . "\\" . $route["controller"];
        return new $class;
    }

    public static function setControllerFunction(array $route):string 
    {
        return $route["function"] ?? null;
    }

    public static function buildMiddlewares(array $route):array|null 
    {
        $middlewares=null;
        if(isset($route["middlewares"]))
            $middlewares=$route["middlewares"];
        return $middlewares;
    }

}