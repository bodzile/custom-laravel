<?php

namespace Src\Routing;

class Route
{
    public static array $links=[];
    public string $currentRoute;
    public static string $prefix_name="";
    public static array|string $middlewares=[];

    private static function setMethodValues(string $method,string $path,string $controller_class,string $function):Route
    {
        $instance=new Route;
        $instance->currentRoute=$path;

        $routeParamName="";
        if(RouteHelper::containRouteParamInRoutes($path))
        {
            $routeParamName=RouteHelper::getRouteParamNameFromUrl($path);
            $path=RouteHelper::cutRouteParamNameFromUrl($path);
        }
            
        static::$links[$path]=[
            "method" => $method,
            "controller" => $controller_class,
            "function" => $function,
        ];

        if(!empty($routeParamName))
            static::$links[$path]["routeParamName"]=$routeParamName;
        
        return $instance;
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
        $instance=new Route;
        $instance->currentRoute=$path;

        static::$links[$path]=[
            "method" => "view",
            "view" => $view,
        ];

        return $instance;
    }

    public function name(string $name):Route
    {
        $path=$this->currentRoute;
        static::$links[$path]["name"]=$name;
        return $this;
    }

    public static function prefix(string $prefix):Route
    {
        self::$prefix_name=$prefix;
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
            self::$middlewares=$temp;
            
        }
        else
        {
            self::$middlewares=$class_prefix . $all_middlewares;
        }
        
        return new self();
    }

    public static function group($function):void
    {
        //prosledjuju se podaci preko chained funkcija middleware i prefix ili samo middleware ili samo prefix
        //prvo uzme sve kljuceve odnosno putanje iz linkova
        //pozove se funkcija koja setuje nove rute
        //onda uzimamo sve rute koji se ne nalaze u nizu kljuceva
        //preradjujemo link tako sto dodajemo prefix i middleware

        $old_links=static::$links;
        
        $function();
        $group_keys=array_keys(array_diff_key(static::$links,$old_links));

        foreach(static::$links as $path => $values)
        {
            if(in_array($path,$group_keys))
            {
                $route=$path;
                if(static::$prefix_name!="")
                {
                    $route=static::$prefix_name . $path;
                    static::$links[$route]=$values; 
                    unset(static::$links[$path]);
                }

                if(!empty(static::$middlewares))
                {
                    static::$links[$route]["middlewares"]=static::$middlewares;
                }    

            }
        }

        self::$middlewares=[];
        self::$prefix_name="";
    }

}

