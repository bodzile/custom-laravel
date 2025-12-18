<?php

namespace Src\Models;

use ReflectionClass;
use ReflectionException;
use App\Models\Model;
use Src\Exceptions\ModelNotFoundException;

class ModelBinder{

    public static function resolve(string $modelName, string $param, mixed $value):Model
    {
        try
        {
            if (!class_exists($modelName)) 
            {
                throw new ReflectionException("Class $modelName not found");
            }

            $ref=new ReflectionClass($modelName);
            $modelObj=$ref->newInstance();
        }
        catch(ReflectionException $ex)
        {
            throw new ModelNotFoundException("Model: $modelName doesn't exist", 0, $ex);
        }

        return $modelObj->query()->where([$param => $value])->first();
    }    


}