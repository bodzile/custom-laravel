<?php

namespace Src\Models;

use App\Models\Model;
use Src\Queries\TableSchema;
use Src\Exceptions\ModelNotFoundException;

class ModelHydrator{

    public static function hydrateObjects(string $table, string $modelClass,array $stdObjects, array $columns):array
    {
        $res=[];
        $unsetColumns=array_diff(TableSchema::getColumns($table), $columns);

        if (!class_exists($modelClass)) 
            throw new ModelNotFoundException;        
            
        foreach($stdObjects as $obj)
        {
            $modelObj=new $modelClass;
            foreach($columns as $column)
                $modelObj->$column=$obj->$column;
            
            foreach($unsetColumns as $column)
                $modelObj->$column=null;
            
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