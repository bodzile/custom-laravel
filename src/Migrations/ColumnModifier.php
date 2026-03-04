<?php

namespace Src\Migrations;

use Src\Migrations\ColumnDefinition;

class ColumnModifier
{
    public function __construct(
        private ColumnDefinition $column
    ){}

    public function default($value):ColumnModifier
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

    public function primary():ColumnModifier
    {
        $this->column->key="PRIMARY";
        return $this;
    }

    public function unique():ColumnModifier
    {
        $this->column->key="UNIQUE";
        return $this;
    }



    public function change():void
    {
        $this->column->operation="ALTER";
    }


}