<?php

namespace Src\Migrations\Schema;

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