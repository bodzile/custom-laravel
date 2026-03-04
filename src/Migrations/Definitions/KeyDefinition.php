<?php

namespace Src\Migrations\Definitions;

use Src\Migrations\Enums\KeyType;

class KeyDefinition
{
    public function __construct(
        public string $column,
        public KeyType $type,
        public string $reference="",
        public string $on=""
    ){}

    public function references(string $column):KeyDefinition
    {
        $this->reference=$column;
        return $this;
    }

    public function on(string $table):KeyDefinition
    {
        $this->on=$table;
        return $this;
    }
}