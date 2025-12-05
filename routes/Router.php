<?php

namespace Routes;

use Routes\RouterObjectBuilder;
use Routes\RouterValidator;
use Routes\Route;
use Routes\RouteHelper;
use App\Http\Requests\Request;
use Src\Pipeline;

class Router{

    private string $url;
    private Request $request;
    private $url_value;

    public function __construct()
    {
        $this->url=RouterObjectBuilder::buildUrl();
        $this->request=RouterObjectBuilder::buildRequest();

        RouterValidator::validate($this->url);
        $this->url_value=RouterObjectBuilder::setUrlValue($this->url);
    }

    public function route()
    {
        $route = Route::$links[$this->url];
        $controllerClass="App\\Http\\Controllers\\" . $route["controller"];
        $function = $route["function"] ?? null;

        $middlewares=null;
        if(isset($route["middlewares"]))
            $middlewares=$route["middlewares"];

        if(!$this->isCorrectMethod($route["method"])) die("wrong method");

        $controller=new $controllerClass;

        switch($route["method"])
        {
            case "get": case "post":
                $pipeline=$middlewares;
                if($pipeline)
                {
                    Pipeline::send($this->request,$this->url_value)
                    ->through($pipeline)
                    ->to(function($data) use($controller,$function) {
                        $controller->$function($this->request,$this->url_value);
                    });
                }
                
                else
                {
                    $controller->$function($this->request,$this->url_value);
                }
                
                break;
            case "view":
                $view=$route["view"];
                $controller->view($view);
                break;
        }
    }

    private function isCorrectMethod(string $method)
    {
        if(isset($_SERVER["REQUEST_METHOD"]) && $method != "view")
        {
            if($method != strtolower($_SERVER["REQUEST_METHOD"]) )
            {
                return false;
            }
        }
        return true;
    }

}