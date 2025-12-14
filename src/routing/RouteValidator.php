<?php

namespace Src\Routing;

use Src\Routing\Route;
use Src\Exceptions\RouteValidationException;

class RouteValidator{

    public function __construct(
        private RouteData $route
    ){}

    public static function validate(RouteData $route):void
    {
        try 
        {
            $validator=new RouteValidator($route);
            $validator->checkDuplicateRoute();
            $validator->checkRequiredRouteData();
        }
        catch(RouteValidationException $ex)
        {
            die($ex->getMessage());
        }
        catch(\Exception $ex)
        {
            die($ex->getMessage());
        }
    }

    private function checkDuplicateRoute():void 
    {
        if(count(Route::$routes) < 1)
            return;
        foreach(Route::$routes as $route)
        {
            if($this->route->url == $route->url)
                throw new RouteValidationException("There is duplicate of route with same url!");;
        }
    }

    private function checkRequiredRouteData():void 
    {
        $required=[
            "url", "method"
        ];
        foreach($required as $property)
        {
            if(empty($this->route->$property))
                throw new RouteValidationException("Not all required data are set in routes!");
        }
    }

}