<?php

use Src\Database;
use Src\Project;
use Routes\Route;

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
        //die($value);
    }
    foreach(Route::$links as $path => $value)
    {
        if( isset($value["name"]))
        {
            if($value["name"] == $route_name)
            {
                if($value_passed != "")
                    return root() . $path . $value_passed ;
                return root() . $path;
            }
        }
    }

    return null;
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
