<?php

namespace Src\Migrations;

use Src\Migrations\ColumnTypes;
use Src\Migrations\ColumnDefinition;
use Src\Migrations\ColumnModifier;

class Blueprint
{

    private static array $columns=[];

    public static function print()
    {
        print_r(static::$columns);
    }

    public function id():void
    {

    }

    public function timestamps():void
    {

    }
    public function string(string $name, int $length=0):ColumnModifier
    {
        return $this->createAndAddColumnDefinition($name, ColumnTypes::STRING, $length);
    }

    public function text(string $name):ColumnModifier
    {
        return $this->createAndAddColumnDefinition($name, ColumnTypes::TEXT);
    }

    public function integer(string $name):ColumnModifier
    {
        return $this->createAndAddColumnDefinition($name, ColumnTypes::INTEGER);
    }

    public function smallInteger(string $name):ColumnModifier
    {
        return $this->createAndAddColumnDefinition($name, ColumnTypes::SMALL_INT);
    }

    public function bigInteger(string $name):ColumnModifier
    {
        return $this->createAndAddColumnDefinition($name, ColumnTypes::BIG_INTEGER);
    }

    public function boolean(string $name):ColumnModifier
    {
        return $this->createAndAddColumnDefinition($name, ColumnTypes::BOOLEAN);
    }

    public function date(string $name):ColumnModifier
    {
        return $this->createAndAddColumnDefinition($name, ColumnTypes::DATE);
    }

    public function dateTime(string $name):ColumnModifier
    {
        return $this->createAndAddColumnDefinition($name, ColumnTypes::DATETIME);
    }

    public function decimal(string $name):ColumnModifier
    {
        return $this->createAndAddColumnDefinition($name, ColumnTypes::DECIMAL);
    }

    public function float(string $name):ColumnModifier
    {
        return $this->createAndAddColumnDefinition($name, ColumnTypes::FLOAT);
    }

    public function json(string $name):ColumnModifier
    {
        return $this->createAndAddColumnDefinition($name, ColumnTypes::JSON);
    }

    private function createAndAddColumnDefinition(string $name, ColumnTypes $type, int $length=255):ColumnModifier
    {
        $column=new ColumnDefinition($type, $name, $length);
        static::$columns[]=$column;
        return new ColumnModifier($column);
    }

    public function dropColumn(string|array $name):void
    {

    }
}