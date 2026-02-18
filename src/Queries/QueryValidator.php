<?php

namespace Src\Queries;

use Exception;
use Src\Exceptions\ColumnNotFoundInAllowedException;
use Src\Exceptions\InvalidAggregateQueryException;
use Src\Queries\TableSchema;
use Src\Queries\QueryBuilder;

class QueryValidator{

    public static function validateAllowedParameters(array $columns, array $allowed, string $table):void
    {
        if(count($columns)==1 && $columns[0]=="*")
            return;
        foreach($columns as $column)
        {
            if($column == TableSchema::getPrimaryKey($table))
                continue;
            
            if(!in_array($column,$allowed) && $column != TableSchema::getPrimaryKey($table))
                throw new ColumnNotFoundInAllowedException;
        }
    }

    public static function validateAggregates(QueryParts $queryParts):void
    {
        if(!$queryParts->aggregates)
            throw new InvalidAggregateQueryException;

    }

}