<?php

namespace Src\Migrations\Schema;

class Schema
{
    public static function create(string $tableName, callable $function):void
    {
        //check if table exist
//        if(Schema::hasTable($tableName))
//            throw new \Exception("Table '$tableName' already exists");

        $blueprint=new Blueprint();
        $function($blueprint);
        //$blueprint->print();
        $sql=SchemaSqlBuilder::create($tableName, $blueprint);
//        SchemaExecutor::executeNonQuery($sql);
//        print_r($table); die();
    }

    public static function table(string $tableName, callable $function):void
    {

    }

    public static function hasTable(string $tableName):bool
    {
        return false;
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