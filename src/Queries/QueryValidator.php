<?php

namespace Src\Queries;

use Exception;
use Src\Queries\TableSchema;

class QueryValidator{

    public static function validateAllowedParameters(array $params, array $allowed, string $table):void
    {
        try
        {
            foreach($params as $column => $value)
            {
                if($column == TableSchema::getPrimaryKey($table))
                    continue;
                
                if(!in_array($column,$allowed) && $column != TableSchema::getPrimaryKey($table))
                    throw new \Exception("Column is not inside allowed array");
            }
        }
        catch(Exception $ex)
        {
            die($ex->getMessage());
        }
    }

}