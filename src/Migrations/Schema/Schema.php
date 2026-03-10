<?php

namespace Src\Migrations\Schema;

use Src\Exceptions\TableAlreadyExistException;
use Src\Queries\QueryExecutor;
use Exception;

class Schema
{
    public static function create(string $tableName, callable $function):void
    {
        //check if table exist
        if(Schema::hasTable($tableName))
            throw new TableAlreadyExistException;

        $blueprint=new Blueprint();
        $function($blueprint);
        //SchemaRepository::createTable($tableName, $blueprint);
    }

    public static function table(string $tableName, callable $function):void
    {

    }

    public static function hasTable(string $tableName):bool
    {
        return SchemaRepository::tableExists($tableName);
    }

    public static function hasColumn(string $tableName, string $columnName):bool
    {
        return false;
    }

    public static function drop($tableName):void
    {

    }

    public static function dropIfExists($tableName):void
    {

    }

}