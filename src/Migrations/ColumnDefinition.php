<?php

namespace Src\Migrations;

use Src\Migrations\ColumnTypes;

class ColumnDefinition
{

    public string|array $default="";
    public bool $nullable=false;
    public string $key="";
    public bool $auto_increment=false;

    public string $operation="ADD";
    public function __construct(
        public ColumnTypes $type,
        public string $name,
        public int $length=255,

    ){}

}