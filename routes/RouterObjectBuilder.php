<?php

namespace routes;

use Routes\Route;
use Routes\RouteHelper;
use App\Http\Requests\Request;

class RouterObjectBuilder{

    static function createRequest():Request 
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

    static function createUrl():string 
    {
        $url = RouteHelper::extractPath($_SERVER["REQUEST_URI"]);
        if($_SERVER["REQUEST_METHOD"] == "GET")
            $url=RouteHelper::cutGetFromUrl($url);
        return $url;
    }

}