<?php

namespace Src\Routing;

use Src\Routing\RouterObjectBuilder;
use Src\Routing\RouterValidator;
use Src\Routing\RouteData;
use App\Http\Requests\Request;
use Src\Pipeline;

class Router{

    private string $url;
    private $url_value;
    private Request $request;
    private RouteData $route;

    public function __construct()
    {
        $this->buildObjects();
    }

    public function validate():void
    {
        RouterValidator::validate($this);
    }

    public function route():void
    {
        $controller=RouterObjectBuilder::buildController($this->route->controller);
        $function=RouterObjectBuilder::getExistingDataOrNull($this->route->function);
        $middlewares=RouterObjectBuilder::getExistingDataOrNull(null);
        
        switch($this->route->method)
        {
            case "get": case "post":

                Pipeline::send($this->request)
                    ->through($middlewares)
                    ->to(function($data) use($controller,$function) {
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
        $this->url=RouterObjectBuilder::buildUrl();
        $this->url_value=RouterObjectBuilder::setUrlValue($this->url);
        $this->route=RouterObjectBuilder::buildRoute($this->url);
        $this->request=RouterObjectBuilder::buildRequest();
    }

    public function __get(string $name)
    {
        if($name == "url")
            return $this->url;
        else if($name == "url_value")
            return $this->url_value;
        else if($name == "route")
            return $this->route;
        else
            return "";
    }

}