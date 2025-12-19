<?php

use Src\Database;
use Src\Project;
use Src\Routing\Route;

require_once "vendor/autoload.php";

enum Purpose:string {
    case SINGLE_USE ="single";
}


function view($view,$data=[]):void
{
    //extract otpakuje sve podatke
    extract($data);
    require_once "resources/views/{$view}.php";
}

// function viewRelative(string $viewPath, $data=[]):void
// {
//     extract($data);
//     require_once  "/" . $viewPath . ".php";
// }

function getDatabaseParam()
{
    return Database::$db_info;
}

function root()
{
    return Project::$project_name;
}

function redirect($path="")
{
    if($path != "")
    {
        header("Location: " . root() . $path);
    }   
    return $this;
}

function route($route_name, array $param=[])
{
    $value_passed="";
    if(!empty($param))
    {
        $value_passed=$param[array_key_first($param)];
    }
    foreach(Route::$routes as $route)
    {
        if(!empty($route->name) && $route->name == $route_name)
        {
            if($value_passed != "")
                return root() . $route->url . $value_passed ;
            return root() . $route->url;
            
        }
    }

    return root() . "/";
}

function compact2(...$keys)
{
    $result=[];
    foreach($keys as $key)
    {
        global $$key;
        $result[$key] = $$key;
    }
    return $result;
}
