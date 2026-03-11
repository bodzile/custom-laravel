<?php

namespace Src\Migrations\Definitions;


use Src\Migrations\Enums\KeyType;
use Src\Migrations\Schema\Blueprint;

class ColumnModifier
{
    public function __construct(
        private Blueprint $table,
        private ColumnDefinition $column
    ){}

    public function primary():ColumnModifier
    {
        $this->table->validator->validatePrimaryKey();
        $this->table->addKey(new KeyDefinition($this->column->name,KeyType::PRIMARY)); ;
        return $this;
    }
    public function foreign():KeyDefinition
    {
        $key=new KeyDefinition($this->column->name, KeyType::FOREIGN);
        $this->table->addKey($key); ;
        return $key;
    }

    public function default(mixed $value):ColumnModifier
    {
        $this->column->default=$value;
        return $this;
    }

    public function nullable():ColumnModifier
    {
        $this->column->nullable=true;
        return $this;
    }

    public function autoIncrement():ColumnModifier
    {
        $this->column->auto_increment=true;
        return $this;
    }

    public function unsigned():ColumnModifier
    {
        $this->column->unsigned=true;
        return $this;
    }

    public function unique():ColumnModifier
    {
        $this->column->unique=true;
        return $this;
    }



    public function change():void
    {
        $this->column->operation="ALTER";
    }


}