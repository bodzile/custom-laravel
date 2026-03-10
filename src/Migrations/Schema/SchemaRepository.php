<?php

namespace Src\Migrations\Schema;

use Src\Database;
use Src\Exceptions\TableAlreadyExistException;
use Src\Queries\QueryExecutor;

class SchemaRepository
{

    public static function createTable(string $tableName, Blueprint $blueprint):void
    {
        if(Schema::hasTable($tableName))
            throw new TableAlreadyExistException;
        $sql=SchemaSqlBuilder::create($tableName, $blueprint);
        QueryExecutor::executeNonQuery(Database::getConnection(), $sql);
    }

    public static function tableExists(string $tableName):bool
    {
        $sql=SchemaSqlBuilder::tableExists($tableName);
        $res=QueryExecutor::executeQuery(Database::getConnection(), $sql);
        if($res[0]->result > 0)
            return true;
        return false;
    }

    public static function dropTableIfExists($tableName):void
    {
        $sql=SchemaSqlBuilder::dropTableIfExists($tableName);
        QueryExecutor::executeNonQuery(Database::getConnection(), $sql);
    }

    public static function dropTable(string $tableName):void
    {

    }

}