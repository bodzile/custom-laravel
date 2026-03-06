<?php

namespace Src\Migrations\Schema;

use Src\Migrations\Definitions\ColumnDefinition;
use Src\Migrations\Definitions\ColumnDefinitionToSqlConverter;

class SchemaSqlBuilder
{
    public static function create(string $table, Blueprint $blueprint):string
    {
        $columns=SchemaSqlBuilder::buildColumns($blueprint->getColumns());
        $keys=SchemaSqlBuilder::buildKeyConstraints($blueprint->getKeys());

        echo "<br>$columns<br>"; die();
        $res="CREATE TABLE $table" . "($columns" . $keys . ");";

        return $res;
    }

    private static function buildColumns(array $columns):string
    {
        $res="";
        foreach ($columns as $column)
        {
            $res.=ColumnDefinitionToSqlConverter::convert($column) . ",<br>";
        }
        return $res;
    }

    private static function buildKeyConstraints(array $keys):string
    {
        return "";
    }
}