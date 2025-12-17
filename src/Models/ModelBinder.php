<?php

namespace Src\Models;

use ReflectionClass;
use App\Models\Model;

class ModelBinder{

    public static function resolve(string $modelName, string $param, mixed $value):Model
    {
        $modelClass="App\\Models\\" . $modelName;
        $ref=new ReflectionClass($modelClass);

        $modelObj=$ref->newInstance();
        return $modelObj->query()->where([$param => $value])->first();
    }    


}