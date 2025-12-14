<?php

namespace Src\Routing;

use Src\Routing\RouteValidator;


class Route
{
    public static array $routes=[];
    public static $groupActive=false;
    private static array $tempRouteData=[
        "url" => "",
        "method" => "",
        "prefix" => "",
        "name" => "",
        "controller" => "",
        "function" => "",
        "view" => "",
        "middlewares" => []
    ];
    private static array $tempRouteGroupData;

    private static function setMethodValues(string $method,string $path,string $controller_class,string $function):Route
    {
        static::$tempRouteData=array_replace(static::$tempRouteData,[
            "url" => $path,
            "method" => $method,
            "controller" => $controller_class,
            "function" => $function,
        ]);
        
        return new self();
    }

    //funkcija koja setuje niz linkova i do kojih kontrolera i funkcija vodi
    public static function get(string $path,string $controller_class,string $function):Route
    {
        return static::setMethodValues("get",$path,$controller_class,$function);
    }

    public static function post(string $path,string $controller_class,string $function):Route
    {
        return static::setMethodValues("post",$path,$controller_class,$function);
    }

    public static function view(string $path,string $view):Route
    {
        static::$tempRouteData=array_replace(static::$tempRouteData,[
            "url" => $path,
            "method" => "view",
            "view" => $view
        ]);

        return new self();
    }

    public static function name(string $name):Route
    {
        static::$tempRouteData=array_replace(static::$tempRouteData,[
            "name" => $name
        ]);

        return new self();
    }

    public static function prefix(string $prefix):Route
    {
        static::$tempRouteData=array_replace(static::$tempRouteData, [
            "prefix" => $prefix
        ]);
        return new self();
    }

    public static function middleware(array|string $all_middlewares):Route
    {
        $temp=[];
        $class_prefix="App\\Http\\Middlewares\\";
        if(is_array($all_middlewares))
        {
            $i=0;
            foreach($all_middlewares as $middleware)
            {
                $temp[$i++]=$class_prefix . $middleware;
            }
        }
        else
        {
            $temp=$class_prefix . $all_middlewares;
        }

        static::$tempRouteData=array_replace(static::$tempRouteData, [
            "middlewares" => $temp
        ]);
        
        return new self();
    }

    public static function group(callable $function):void
    {
        static::$groupActive=true;
        static::$tempRouteGroupData=static::$tempRouteData;
        
        $function();

        static::$groupActive=false;
    }

    public function build():void
    {
        $route=$this->buildRouteData();
        $this->resetRouteData();
        RouteValidator::validate($route);

        static::$routes[]=$route;
    }

    private function buildRouteData():RouteData 
    {
        $tmp=static::$tempRouteData;
        return new RouteData(
            $tmp["prefix"] . $tmp["url"],
            $tmp["method"],
            $tmp["name"],
            $tmp["controller"],
            $tmp["function"],
            $tmp["view"],
            $tmp["middlewares"]
        );
    }

    private function resetRouteData():void 
    {
        // if routes from group are called 
        // all cummulated routes data will be saved
        if(static::$groupActive)
        {
            static::$tempRouteData=static::$tempRouteGroupData;
        }
        else
        {
            static::$tempRouteData=[
                "url" => "",
                "method" => "",
                "prefix" => "",
                "name" => "",
                "controller" => "",
                "function" => "",
                "view" => "",
                "middlewares" => []
            ];
            static::$tempRouteGroupData=static::$tempRouteData;
        }
        
    }

}

