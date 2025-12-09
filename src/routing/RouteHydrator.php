<?php

namespace Src\Routing;

use Src\Routing\RouteData;
use Src\Routing\Route;

class RouteHydrator{

    public static function hydrateRouteData(string $url):RouteData
    {
        if(!isset(Route::$links[$url]))
            return null;

        $routeData=new RouteData();
        foreach(Route::$links[$url] as $key => $value)
        {
            $routeData->$key=$value;
        }
        return $routeData;
    }

}