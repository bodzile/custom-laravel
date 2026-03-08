<?php

namespace Src\Migrations\Schema;

use Src\Migrations\Definitions\ColumnDefinition;
use Src\Migrations\Definitions\ColumnModifier;
use Src\Migrations\Definitions\KeyDefinition;
use Src\Migrations\Enums\ColumnTypes;
use Src\Migrations\Enums\SqlFunctions;

class Blueprint
{

    private array $columns=[];
    private array $keys=[];

    public function print()
    {
        foreach($this->columns as $column)
        {
            echo "Column:<br>";
            print_r($column);
            echo "<br>";
        }

        echo "<br>Keys: ";
        foreach($this->keys as $key)
        {
            echo "<br>";
            print_r($key);
            echo "<br>";
        }
    }

    public function id():void
    {
        $this->createAndAddColumnDefinition("id", ColumnTypes::INTEGER)->primary()->autoIncrement();
    }

    public function foreignId(string $name):KeyDefinition
    {
        return $this->createAndAddColumnDefinition($name, ColumnTypes::INTEGER)->foreign();
    }

    public function timestamps():void
    {
        $this->createAndAddColumnDefinition("created_at", ColumnTypes::TIMESTAMP)->default(SqlFunctions::CurrentTimestamp);
        $this->createAndAddColumnDefinition("updated_at", ColumnTypes::TIMESTAMP)->default(SqlFunctions::CurrentTimestamp);
    }
    public function string(string $name, ?int $length=null):ColumnModifier
    {
        $length=$length ?? ColumnTypes::STRING->getDefaultLength();
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

    public function addKey(KeyDefinition $key):void
    {
        $this->keys[] = $key;
    }

    private function createAndAddColumnDefinition(string $name, ColumnTypes $type, int $length=255):ColumnModifier
    {
        $column=new ColumnDefinition($type, $name, $length);
        $this->columns[]=$column;
        return new ColumnModifier($this, $column);
    }

    public function dropColumn(string|array $name):void
    {

    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getKeys(): array
    {
        return $this->keys;
    }
}