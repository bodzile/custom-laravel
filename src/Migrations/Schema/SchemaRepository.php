<?php

namespace Src\Migrations\Schema;

use Src\Database;
use Src\Queries\QueryExecutor;

class SchemaRepository
{

    public static function createTable(string $tableName, Blueprint $blueprint):void
    {
        $sql=SchemaSqlBuilder::create($tableName, $blueprint);
        QueryExecutor::executeNonQuery(Database::getConnection(), $sql);
    }

}