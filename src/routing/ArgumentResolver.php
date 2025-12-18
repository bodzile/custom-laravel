<?php

namespace Src\Routing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Src\Models\ModelBinder;
use Src\Controllers\ControllerMetaData;

class ArgumentResolver{

    // it returns array of arguments
    // it also create each argument as needed type
    public static function resolve(
        Controller $controller,
        string $function,
        Request $request,
        array $params
    ):array
    {
        $res=[$request];
        $value=ArgumentResolver::buildRouteParamValue(
            $request->getRouteParamValue(),
            $params,
            $function,
            $controller
        );

        if(!empty($value))
            $res=array_merge($res,[$value]);

        return $res;
    }

    private static function buildRouteParamValue(mixed $value, array $params, string $function, Controller $controller):mixed
    {
        if(empty($value))
            return "";

        $parameters=ControllerMetaData::getParameters($controller, $function);
        if(count($parameters)>1)
        {
            $type=$parameters[1]->getType();
            // different than int, string, float, bool, array,...
            if(!$type->isBuiltin())
                return ModelBinder::resolve($type->getName(), array_key_first($params), $value);   
        }

        return $value;
    }


}