<?php

namespace Src\Migrations\Definitions;

use Src\Migrations\Enums\ColumnTypes;

class ColumnDefinition
{

    //add, alter
    public string $operation="";
    public mixed $default="";
    public bool $nullable=false;
    public bool $unsigned=false;
    public bool $unique=false;
    public bool $auto_increment=false;


    public function __construct(
        public ColumnTypes $type,
        public string $name,
        public ?int $length=null,

    ){
        if($this->length===null)
            $this->length=$this->type->getDefaultLength();
        else if($this->length == PHP_INT_MAX)
            $this->length=$this->type->getMaxLength();
    }

}