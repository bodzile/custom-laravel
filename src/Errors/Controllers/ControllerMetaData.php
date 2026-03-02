<?php

namespace Src\Errors\Controllers;

use App\Http\Controllers\Controller;
use ReflectionClass;
use ReflectionException;
use Src\Exceptions\ControllerMethodNotFoundException;

class ControllerMetaData{

    public static function getParameters(Controller $controller, string $function):mixed
    {
        try
        {
            $ref=new ReflectionClass($controller);
            $method=$ref->getMethod($function);
        }
        catch(ReflectionException $ex)
        {
            $className = get_class($controller);
            throw new ControllerMethodNotFoundException("Method $function doesn't exist in controller: $className", 0, $ex);
        }
       

        return $method->getParameters();
    }

}