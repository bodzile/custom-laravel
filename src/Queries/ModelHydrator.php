<?php

namespace src\Queries;

use Src\Queries\QueryExecutor;
use Src\Queries\QuerySqlBuilder;
use App\Http\Requests\Request;
use App\Models\Model;

class ModelHydrator{

    public static function hydrateObjects(string $modelClass,array $stdObjects, array $columns):array
    {
        $res=[];
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

    public static function hydrateObject(string $modelClass, array $stdObjects, array $columns):Model
    {
        $modelObj=null;
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