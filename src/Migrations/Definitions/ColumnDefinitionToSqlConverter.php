<?php

namespace Src\Migrations\Definitions;

use Src\Migrations\Enums\ColumnTypes;
use Src\Migrations\Enums\SqlFunctions;

class ColumnDefinitionToSqlConverter
{
    public static function convert(ColumnDefinition $column):string
    {
        $type=self::typeToSql($column->type, $column->length);
        $unsigned=self::unsignedToSql($column->unsigned);
        $null=self::nullableToSql($column->nullable);
        $default=self::defaultToSql($column->default);
        $unique=self::uniqueToSql($column->unique);
        $autoIncrement=self::autoIncrementToSql($column->auto_increment);

        $res=$column->operation . " " . $column->name . " " . $type . " " . $unsigned . " " . $null . " " . $default . " " . $unique . " " . $autoIncrement;
        return $res;
    }

    private static function typeToSql(ColumnTypes $type, ?int $length):string
    {
        return match ($type) {
          ColumnTypes::STRING => $type->value . "($length)",
          default => $type->value
        };
    }

    private static function unsignedToSql(bool $unsigned):string
    {
        return $unsigned ? "UNSIGNED" : "";
    }

    private static function defaultToSql(mixed $default):string
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

    private static function nullableToSql(bool $nullable):string
    {
        return $nullable ? "NULL" : "NOT NULL";
    }

    private static function uniqueToSql(bool $unique):string
    {
        return $unique ? "UNIQUE" : "";
    }

    private static function autoIncrementToSql(bool $autoIncrement):string
    {
        return $autoIncrement ? "AUTO_INCREMENT" : "";
    }
}