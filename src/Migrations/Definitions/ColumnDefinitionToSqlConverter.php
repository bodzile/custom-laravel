<?php

namespace Src\Migrations\Definitions;

use Src\Migrations\Enums\ColumnTypes;
use Src\Migrations\Enums\SqlFunctions;

class ColumnDefinitionToSqlConverter
{
    public static function convert(ColumnDefinition $column):string
    {
        $type=self::typeToSql($column->type, $column->length);
        $null=self::nullableToSql($column->nullable);

        $default=self::defaultToSql($column->default);

        $res=$column->operation . " " . $column->name . " " . $type . " " . $null . " " . $default  ;  ;
        return $res;
    }

    public static function typeToSql(ColumnTypes $type, ?int $length):string
    {
        return match ($type) {
          ColumnTypes::STRING => $type->value . "($length)",
          default => $type->value
        };
    }

    public static function defaultToSql(mixed $default):string
    {
        if($default === "")
            return "";
        if(is_string($default))
            $res= "DEFAULT '$default'";
        else if(is_bool($default))
        {
            $convertedBool = $default ? 'true' : 'false';
            $res="DEFAULT " . strtoupper($convertedBool);
        }
        else if($default instanceof SqlFunctions)
            $res="DEFAULT $default->value";
        else
            $res="DEFAULT $default";

        return $res;
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