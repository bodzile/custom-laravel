<?php

namespace Src\Queries;

use Exception;
use Src\Exceptions\ColumnNotFoundInAllowedException;
use Src\Queries\TableSchema;

class QueryValidator{

    // public static function validateAllowedParameters(array $params, array $allowed, string $table):void
    // {
    //     foreach($params as $column => $value)
    //     {
    //         if($column == TableSchema::getPrimaryKey($table))
    //             continue;
            
    //         if(!in_array($column,$allowed) && $column != TableSchema::getPrimaryKey($table))
    //             throw new Exception("Column is not inside allowed array");
    //     }
    // }


    public static function validateAllowedParameters(array $columns, array $allowed, string $table):void
    {
        foreach($columns as $column)
        {
            if($column == TableSchema::getPrimaryKey($table))
                continue;


            // echo $column;
            // print_r($allowed); die();
            
            if(!in_array($column,$allowed) && $column != TableSchema::getPrimaryKey($table))
                throw new ColumnNotFoundInAllowedException;
        }
    }

}