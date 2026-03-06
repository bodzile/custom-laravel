<?php

namespace Src\Migrations\Definitions;

use Src\Migrations\Enums\ColumnTypes;

class ColumnDefinitionToSqlConverter
{
    public static function convert(ColumnDefinition $column):string
    {
        $type=self::typeToSql($column->type, $column->length);
        $null=self::nullableToSql($column->nullable);
        $default=self::defaultToSql($column->default);
        $res=$column->operation . " " . $column->name . " " . $type . " " . $default . " " . $null ;  ;
        return $res;
    }

    public static function typeToSql(ColumnTypes $type, ?int $length):string
    {
        return match ($type) {
          ColumnTypes::STRING => $type->value . "($length)",
          default => $type->value
        };
    }

    public static function defaultToSql(string $default):string
    {
        if($default=="")
            return "";
        $defaultValue=match($default){
            "CURRENT_TIMESTAMP"=>"CURRENT_TIMESTAMP",
            default => "'$default'"
        };
        return "DEFAULT $defaultValue";
    }

    public static function nullableToSql(bool $nullable):string
    {
        return $nullable ? "NULL" : "NOT NULL";
    }

    public static function autoIncrementToSql(bool $autoIncrement):string
    {
        return "";
    }
}