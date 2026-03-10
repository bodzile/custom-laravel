<?php

namespace Src\Migrations\Schema;

use Src\Database;
use Src\Migrations\Definitions\ColumnDefinition;
use Src\Migrations\Definitions\ColumnDefinitionToSqlConverter;
use Src\Migrations\Definitions\KeyDefinitionToSqlConverter;

class SchemaSqlBuilder
{
    public static function create(string $table, Blueprint $blueprint):string
    {
        $columns=SchemaSqlBuilder::buildColumns($blueprint->getColumns());
        $keys=SchemaSqlBuilder::buildKeyConstraints($blueprint->getKeys());
        if(!empty($keys))
            $res=implode(",",[$columns,$keys]);
        else
            $res=$columns;

        return "CREATE TABLE $table($res);";
    }

    public static function tableExists(string $table):string
    {
        $schemaName=Database::getSchemaName();
        return "SELECT COUNT(*) AS result FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$schemaName' AND TABLE_NAME = '$table';";
    }

    public static function dropTableIfExists(string $table):string
    {
        return "DROP TABLE IF EXISTS $table";
    }

    private static function buildColumns(array $columns):string
    {
        $res=[];
        foreach ($columns as $column)
        {
            $res[]=ColumnDefinitionToSqlConverter::convert($column);
        }
        return implode(",", $res);
    }

    private static function buildKeyConstraints(array $keys):string
    {
        $res=[];
        foreach ($keys as $key)
        {
            $res[]=KeyDefinitionToSqlConverter::convert($key);
        }
        return implode(",", $res);
    }
}