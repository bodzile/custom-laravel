<?php

namespace Src\Queries;

use Src\Queries\QuerySqlBuilder;
use Src\Queries\QueryExecutor;
use Src\Database;

class TableSchema{

    private static function getMetadata(string $table):array 
    {
        $sql=QuerySqlBuilder::buildDescribe($table);
    
        return QueryExecutor::executeQuery(
            Database::getConnection(),
            $sql
        );
    }

    public static function getPrimaryKey(string $table):string
    {
        $metadata=static::getMetadata($table);
        foreach($metadata as $stdObject)
        {
            if($stdObject->Key == "PRI")
                return $stdObject->Field;
        }
        return "";
    }

    public static function getColumns(string $table):array 
    {
        $columns=[];
        $metadata=static::getMetadata($table);
        foreach($metadata as $stdObject)
        {
            $columns[]=$stdObject->Field;
        }
        return $columns;
    }

    public static function getColumnTypes(string $table):array 
    {
        $columns=[];
        $metadata=static::getMetadata($table);
        foreach($metadata as $stdObject)
        {
            $columns[$stdObject->Field]=$stdObject->Type;
        }
        return $columns;
    }

    public static function createdAtExist(string $table):string
    {
        $metadata=static::getMetadata($table);
        foreach($metadata as $stdObject)
        {
            if(strtolower($stdObject->Field) == "created_at" && $stdObject->Type == "timestamp")
                return true;    
        }
        
        return false;
    }

    public static function updatedAtExist(string $table):string
    {
        $metadata=static::getMetadata($table);
        foreach($metadata as $stdObject)
        {
            if(strtolower($stdObject->Field) == "updated_at" && $stdObject->Type == "timestamp")
                return true;    
        }
        return false;
    }

}