<?php

namespace routes;

use Routes\Route;
use Routes\RouteHelper;
use App\Http\Requests\Request;

class RouterObjectBuilder{

    public static function buildRequest():Request 
    {
        $request=new Request;
        switch($_SERVER["REQUEST_METHOD"])
        {
            case "GET":
                $request->setRequestFields($_GET); break;
            case "POST":
                $request->setRequestFields($_POST); break;
        }
        return $request;
    }

    public static function buildUrl():string 
    {
        $url = RouteHelper::extractPath($_SERVER["REQUEST_URI"]);
        if($_SERVER["REQUEST_METHOD"] == "GET")
            $url=RouteHelper::cutGetFromUrl($url);
        return $url;
    }

    public static function setUrlValue(string $url)
    {
        $url_value=null;
        if(!isset(Route::$links[$url]))
        {
            $url=RouteHelper::cutValueFromUrl($url);
            if(isset(Route::$links[$url]["url_value"]))
                $url_value=RouteHelper::getValueFromUrl($url);
        }
        
        return $url_value;
    }

}