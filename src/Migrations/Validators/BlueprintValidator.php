<?php

namespace Src\Migrations\Validators;

use Src\Exceptions\ColumnAlreadyExistInBlueprintException;
use Src\Exceptions\DuplicatePrimaryKeyException;
use Src\Migrations\Definitions\KeyDefinition;
use Src\Migrations\Enums\KeyType;
use Src\Migrations\Schema\Blueprint;

class BlueprintValidator
{

    public function __construct(
        private BLueprint $blueprint
    )
    {}
    public function validateColumnName(string $columnName):void
    {
        foreach($this->blueprint->getColumns() as $column)
        {
            if($column->name === $columnName)
                throw new ColumnAlreadyExistInBlueprintException;
        }
    }

    public function validatePrimaryKey():void
    {
        foreach($this->blueprint->getKeys() as $el)
        {
            if($el->type == KeyType::PRIMARY)
                throw new DuplicatePrimaryKeyException;
        }
    }

}