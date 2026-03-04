<?php

namespace Src\Migrations\Definitions;

use Src\Migrations\Enums\ColumnTypes;

class ColumnDefinition
{

    public string $operation="ADD";
    public string|array $default="";
    public bool $nullable=false;

    public bool $unique=false;
    public bool $auto_increment=false;


    public function __construct(
        public ColumnTypes $type,
        public string $name,
        public int $length=255,

    ){}

}