<?php

namespace Src\Routing;

use Src\Routing\RouterObjectBuilder;
use Src\Routing\RouterValidator;
use Src\Routing\RouteData;
use Src\Routing\Dispatcher;

use App\Http\Requests\Request;
use Src\Exceptions\ModelNotFoundException;
use Src\Exceptions\ControllerMethodlNotFoundException;
use Src\Exceptions\ModelNotMatchInRouteException;

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
        switch($this->route->method)
        {
            case "get": case "post":
                try
                {
                    $dispatcher=$this->createDispatcher();
                    $dispatcher->dispatch();
                }
                catch(ModelNotFoundException $ex)
                {
                    die($ex->getMessage());
                }
                catch(ControllerMethodlNotFoundException $ex)
                {
                    die($ex->getMessage());
                }
                catch(ModelNotMatchInRouteException $ex)
                {
                    die($ex->getMessage());
                }
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

    private function createDispatcher():Dispatcher
    {
        $controller=RouterObjectBuilder::buildController($this->route->controller);
        $function=RouterObjectBuilder::getExistingDataOrNull($this->route->function);
        $middlewares=RouterObjectBuilder::getExistingDataOrNull($this->route->middlewares);

        return new Dispatcher(
            $controller, $function, $middlewares, $this->route->params, $this->request
        );
    }
    
}