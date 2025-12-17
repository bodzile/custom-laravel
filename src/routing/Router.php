<?php

namespace Src\Routing;

use Src\Routing\RouterObjectBuilder;
use Src\Routing\RouterValidator;
use Src\Routing\RouteData;
use App\Http\Requests\Request;
use Src\Routing\Route;
use Src\Pipeline;

class Router{

    private Request $request;
    private RouteData $route;

    public function __construct()
    {
        $this->buildObjects();
    }

    public function validate():void
    {
        RouterValidator::validate($this->route);
    }

    public function route():void
    {
        $controller=RouterObjectBuilder::buildController($this->route->controller);
        $function=RouterObjectBuilder::getExistingDataOrNull($this->route->function);
        $middlewares=RouterObjectBuilder::getExistingDataOrNull($this->route->middlewares);

        switch($this->route->method)
        {
            case "get": case "post":

                Pipeline::send($this->request)
                    ->through($middlewares)
                    ->to(function($data) use($controller,$function) {
                        if(!empty($this->request->getRouteParamValue()))
                        {
                            //print_r($this->request); die();
                            $controller->$function($this->request, $this->request->getRouteParamValue());
                        }
                            
                        else
                            $controller->$function($this->request);
                        
                    });

                break;
            case "view":
                $view=$this->route->view;
                view($view);
                break;
        }
    }

    private function buildObjects():void
    {
        $url=RouterObjectBuilder::buildUrl();
        [$this->route, $routeParamValue]=RouterObjectBuilder::buildRouteAndParamValue($url);
        $this->request=RouterObjectBuilder::buildRequest($routeParamValue);
    }

    public function __get(string $name)
    {
        if($name == "url")
            return $this->route->url;
        else if($name == "url_value")
            return $this->url_value;
        else if($name == "route")
            return $this->route;
        else
            return "";
    }

}