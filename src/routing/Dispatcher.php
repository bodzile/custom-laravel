<?php

namespace Src\Routing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Src\Pipeline;

class Dispatcher{

    public function __construct(
        private Controller $controller,
        private string $function,
        private array|string $middlewares,
        private array $params,
        private Request $request
    ){}

    public function dispatch():void
    {
        $fn=$this->function;
        $arguments=ArgumentResolver::resolve(
            $this->controller,
            $this->function,
            $this->request,
            $this->params
        );
        
        Pipeline::send($this->request)
            ->through($this->middlewares)
            ->to(function($data) use($arguments,$fn) {
                $this->controller->$fn(...$arguments);    
            });
    }

}