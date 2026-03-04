<?php

namespace Src\Migrations;

use Src\Migrations\Migration;

class Schema
{
    public static function create(string $tableName, callable $function):void
    {
        //check if table exist
//        if(Schema::hasTable($tableName))
//            throw new \Exception("Table '$tableName' already exists");

        $table=new Blueprint();
        $function($table);
        Blueprint::print();
//        $sql=SchemaSqlBuilder::buildBlueprint($table);
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