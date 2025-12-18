<?php

namespace Src\Routing;

use Src\Routing\Route;
use Src\Routing\RouteHelper;
use Src\Routing\RouteData;
use Src\Models\ModelBinder;
use App\Models\Model;
use App\Http\Requests\Request;
use App\Http\Controllers\Controller;
use Src\Controllers\ControllerMetaData;

class RouterObjectBuilder{

    public static function buildRequest(mixed $routeParamValue):Request 
    {
        $request=new Request;
        switch($_SERVER["REQUEST_METHOD"])
        {
            case "GET":
                $request->setRequestFields($_GET); break;
            case "POST":
                $request->setRequestFields($_POST); break;
        }
        if($routeParamValue)
            $request->setRouteParamValue($routeParamValue);

        return $request;
    }

    public static function buildUrl():string 
    {
        $url = RouteHelper::extractPath($_SERVER["REQUEST_URI"]);
        if($_SERVER["REQUEST_METHOD"] == "GET")
            $url=RouteHelper::cutGetFromUrl($url);
        
        return $url;
    }

    public static function buildRouteAndParamValue(string $url):array
    {
        foreach(Route::$routes as $route)
        {
            if($route->url == $url)
                return [$route,""];
            if(RouteHelper::containRouteParamInUrl($route->url) && RouteHelper::matchRouteParam($url,$route->url))
                return [$route, RouteHelper::getRouteParamValue($url, $route->url)];
        }
        return [new RouteData(),""];
    }

    public static function buildController(string $controller):Controller|null
    {
        if(empty($controller))
            return null;

        $namespace = (new \ReflectionClass(Controller::class))->getNamespaceName();
        $class=$namespace . "\\" . $controller;
        return new $class;
    }

    public static function getExistingDataOrNull(mixed $data):mixed
    {
        return $data ?? null;
    }

}