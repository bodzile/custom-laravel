<?php

namespace Src\Routing;

use Src\Routing\RouteValidator;


class Route
{
    public static array $routes=[];
    public static array $groupStack=[];
    public static bool $groupActive=false;
    private static array $tempRouteData=[
        "url" => "",
        "method" => "",
        "prefix" => "",
        "name" => "",
        "controller" => "",
        "function" => "",
        "view" => "",
        "middlewares" => [],
        "params" => []
    ];
    private static array $tempRouteGroupData;

    private static function setMethodValues(string $method,string $path,string $controller_class,string $function):Route
    {
        $params=RouteHelper::getRouteParamMetadata($path);

        static::$tempRouteData=array_replace(static::$tempRouteData,[
            "url" => $path,
            "method" => $method,
            "controller" => $controller_class,
            "function" => $function,
            "params" => $params
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
        if(static::$groupActive)
            $name=static::$tempRouteGroupData['name'] . $name;

        static::$tempRouteData=array_replace(static::$tempRouteData,[
            "name" => $name
        ]);

        return new self();
    }

    public static function prefix(string $prefix):Route
    {
        if(static::$groupActive)
            $prefix=static::$tempRouteGroupData['prefix'] . $prefix;

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

            if(static::$groupActive && !empty(static::$tempRouteGroupData['middlewares']))
                $temp=array_merge(static::$tempRouteGroupData['middlewares'], $temp);
        }
        else
        {
            $temp=[$class_prefix . $all_middlewares];
            if(static::$groupActive && !empty(static::$tempRouteGroupData['middlewares']))
                $temp=array_merge(static::$tempRouteGroupData['middlewares'], $temp);
        }

        static::$tempRouteData=array_replace(static::$tempRouteData, [
            "middlewares" => $temp
        ]);
        
        return new self();
    }

    public static function group(callable $function):void
    {
        //print_r(static::$groupActive?"jeste":"nije"); die();

//        echo "<br><h4>Group stack: </h4><br>";
//        print_r(static::$groupStack);
//        echo "<br>";

        if(static::$groupActive)
            static::concatTempGroupData();
        else
            static::$groupActive=true;

        static::$tempRouteGroupData=static::$tempRouteData;
        static::$groupStack[]=static::$tempRouteGroupData;
        
        $function();

        array_pop(static::$groupStack);
        if(count(static::$groupStack) >= 1)
        {
            static::$tempRouteData=static::$groupStack[count(static::$groupStack)-1];
            static::$tempRouteGroupData=static::$tempRouteData;
        }

        if(empty(static::$groupStack))
        {
            static::$groupActive = false;
            static::clearRouteData();
        }
    }

    public function build():void
    {
        $route=$this->buildRouteData();
        print_r("Url: " . $route->url . " Name: " . $route->name); echo "<br>";
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
            $tmp["middlewares"],
            $tmp["params"]
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
           static::clearRouteData();
        }
        
    }

    private static function clearRouteData():void
    {
        static::$tempRouteData=[
            "url" => "",
            "method" => "",
            "prefix" => "",
            "name" => "",
            "controller" => "",
            "function" => "",
            "view" => "",
            "middlewares" => [],
            "params" => []
        ];
        static::$tempRouteGroupData=static::$tempRouteData;
    }

    //it on beginning of every tempRouteData values of tempRouteGroupData
    //example:
    //tempRouteData["middlewares"]=["LatestGroupMiddleware"]
    //tempRouteData["middlewares"]=["ParenGroupMiddleware", "LatestGroupMiddleware"]
    private static function concatTempGroupData():void
    {

        //prefix
//        if(isset(static::$tempRouteData["prefix"]))
//        {
//            echo "Temp route data prefix : " . static::$tempRouteData["prefix"] . "<br>" . "Temp route group data prefix: " . static::$tempRouteGroupData["prefix"];
//            static::$tempRouteData["prefix"]= static::$tempRouteGroupData["prefix"] . static::$tempRouteData["prefix"];
//        }

        //name
//        echo "Temp route data :<br>";
//        print_r( static::$tempRouteData); echo "<br>Tenmp route group data: "; print_r(static::$tempRouteGroupData); echo "<br>";
//        if(isset(static::$tempRouteData["name"]))
//        {
//            static::$tempRouteGroupData["name"] = static::$tempRouteGroupData["name"] . static::$tempRouteData["name"];
//            //echo static::$tempRouteGroupData["name"] . "<br>";
//        }
        //if(isset(static::$tempRouteData[""]))

       // print_r(static::$tempRouteData["name"]);  die();
        //middlewares

    }

}

