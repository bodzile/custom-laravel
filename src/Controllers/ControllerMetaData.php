<?php

namespace Src\Controllers;

use App\Http\Controllers\Controller;
use ReflectionClass;

class ControllerMetaData{

    public static function getParameters(Controller $controller, string $function):mixed
    {
        $ref=new ReflectionClass($controller);
        return $ref->getMethod($function)->getParameters();
    }

}