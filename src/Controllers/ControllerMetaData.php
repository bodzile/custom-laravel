<?php

namespace Src\Controllers;

use App\Http\Controllers\Controller;
use Src\Exceptions\ControllerMethodNotFoundException;
use ReflectionClass;
use ReflectionException;

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