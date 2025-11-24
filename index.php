<?php
use Routes\Route;
use Routes\RouteHelper;
use App\Http\Requests\Request;
use Src\Pipeline;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "vendor/autoload.php";
require_once "routes/web.php";

return new class  {

    private $url;
    private Request $request;
    private $url_value;

    public function __construct()
    {
        
        $this->url=RouteHelper::extractPath($_SERVER["REQUEST_URI"]);
        $this->request=new Request;

        $this->handleRequestMethod();
        $this->handleError404();

        $this->redirect();
    }

    private function handleRequestMethod()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") 
        {
            $this->url = RouteHelper::cutGetFromUrl($this->url);
            $this->request->setRequestFields($_GET);
        } 
        elseif ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $this->request->setRequestFields($_POST);
        }
    }

    private function handleError404()
    {
        foreach(Route::$links as $path => $param)
        {
            if($this->url == $path)
            {
                return;
            }
            
            if(isset($param["url_value"]))
            {
                $this->url_value=RouteHelper::getValueFromUrl($this->url);
                $this->url=RouteHelper::cutValueFromUrl($this->url);
                if($this->url == $path)
                {
                    return;
                }
                $this->url.=$this->url_value;
                $this->url_value=null;
            }
        }

        http_response_code(404);
        die("404 Error: Page not found");
    }

    private function redirect()
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


    private function handleMiddlewares()
    {

    }

};