<?php

namespace Src\Routing;

final readonly class RouteData{

    public function __construct(
        public string $url="",
        public string $method="",
        public string $name="",
        public string $controller="",
        public string $function="",
        public string $view="",
        public array|string $middlewares=[]
    ){}

}