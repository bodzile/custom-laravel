<?php

namespace Src\Models;

use App\Models\Model;
use Src\Exceptions\ModelNotFoundException;

class ModelHydrator{

    public static function hydrateObjects(string $modelClass,array $stdObjects, array $columns):array
    {
        $res=[];
        if (!class_exists($modelClass)) 
            throw new ModelNotFoundException;
            
        foreach($stdObjects as $obj)
        {
            $modelObj=new $modelClass;
            foreach($columns as $column)
            {
                $modelObj->$column=$obj->$column;
            }
            $res[]=$modelObj;
        }

        return $res;
    }

    public static function hydrateObject(string $modelClass, array $stdObjects, array $columns):?Model
    {
        $modelObj=null;
        if (!class_exists($modelClass)) 
            throw new ModelNotFoundException;
        if(count($stdObjects)<=1)
        {
            $modelObj=new $modelClass;
            foreach($columns as $column)
            {
                $modelObj->$column=$stdObjects[0]->$column;
            }
        }
        return $modelObj;
    }

}