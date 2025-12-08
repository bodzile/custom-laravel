<?php

namespace Src\Routing;

use Src\Routing\RouterObjectBuilder;
use Src\Routing\RouterValidator;
use App\Http\Requests\Request;
use Src\Pipeline;

class Router{

    private string $url;
    private Request $request;
    private $url_value;
    private array $route;

    public function __construct()
    {
        $this->buildObjects();
    }

    public function validate():void
    {
        RouterValidator::validate($this);
    }

    public function route()
    {
        $controller=RouterObjectBuilder::buildController($this->route);
        $function=RouterObjectBuilder::setControllerFunction($this->route);
        $middlewares=RouterObjectBuilder::buildMiddlewares($this->route);

        switch($this->route["method"])
        {
            case "get": case "post":
                //$pipeline=$middlewares;
                if($middlewares)
                {
                    Pipeline::send($this->request,$this->url_value)
                    ->through($middlewares)
                    ->to(function($data) use($controller,$function) {
                        $controller->$function($this->request,$this->url_value);
                    });
                }
                
                else
                {
                    $controller->$function($this->request,$this->url_value);
                }
                
                // Pipeline::send($this->request,$this->url_value)
                //     ->through($middlewares)
                //     ->to(function($data) use($controller,$function) {
                //         $controller->$function($this->request,$this->url_value);
                //     });

                break;
            case "view":
                $view=$this->route["view"];
                $controller->view($view);
                break;
        }
    }

    private function buildObjects()
    {
        $this->url=RouterObjectBuilder::buildUrl();
        $this->request=RouterObjectBuilder::buildRequest();
        $this->url_value=RouterObjectBuilder::setUrlValue($this->url);
        $this->route=RouterObjectBuilder::buildRoute($this->url);
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