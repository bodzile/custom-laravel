<?php

namespace Src\Models;

use ReflectionClass;
use ReflectionException;
use App\Models\Model;
use Src\Exceptions\ModelNotFoundException;

class ModelBinder{

    public static function resolve(string $modelName, string $param, mixed $value):?Model
    {
        if (!class_exists($modelName))
            throw new  ModelNotFoundException("Model: $modelName doesn't exist");

        $ref=new ReflectionClass($modelName);
        $modelObj=$ref->newInstance();

        return $modelObj->query()->where([$param => $value])->first();
    }    


}