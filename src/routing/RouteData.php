<?php

namespace Src\Routing;

class RouteData{

    public function __construct(
        public string $url,
        public string $method,
        //public string $prefix,
        public string $name="",
        public string $controller="",
        public string $function="",
        public string $view="",
        public array|string $middlewares=[]
    ){}

}