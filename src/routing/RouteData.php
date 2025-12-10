<?php

namespace Src\Routing;

class RouteData{

    public string $url;
    public string $method;
    public string $controller="";
    public string $view="";
    public string $function="";
    public array $middlewares=[];

}