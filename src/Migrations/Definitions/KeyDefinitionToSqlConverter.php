<?php

namespace Src\Migrations\Definitions;

use Src\Migrations\Enums\KeyType;

class KeyDefinitionToSqlConverter
{
    public static function convert(KeyDefinition $key):string
    {
        switch($key->type)
        {
            case KeyType::PRIMARY:
                $keyValue = "PRIMARY KEY";
                return $keyValue . " ($key->column)";
            case KeyType::FOREIGN:
                $keyValue = "FOREIGN KEY";
                return $keyValue . " ($key->column) " . "REFERENCES " . $key->on . "($key->reference)";
        }

        return "";
    }
}