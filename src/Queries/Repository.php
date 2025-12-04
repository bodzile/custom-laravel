<?php

namespace Src\Queries;

use Src\Queries\ModelHydrator;
use Src\Queries\QueryBuilder;
use Src\Queries\QuerySqlBuilder;
use Src\Queries\QueryExecutor;
use Src\Queries\TableSchema;
use Src\Database;


class Repository{

    private \PDO $pdo;

    public function __construct(
        private string $table,
        private array $allowed,
        private string $modelClass
    ){
        $this->pdo=Database::getConnection();
    }

    public function select(array $query):array
    {
        [$sql,$param]=QuerySqlBuilder::buildSelect($this->table,$query);
        [$stdObjects,$columns]=QueryExecutor::executeSelect(
            $this->pdo, 
            $sql, 
            $param
        );

        return ModelHydrator::hydrateObjects($this->modelClass, $stdObjects, $columns);
    }

    public function selectAll():array
    {
        $sql=QuerySqlBuilder::buildSelectAll($this->table);
        [$stdObjects,$columns]=QueryExecutor::executeSelect(
            $this->pdo, 
            $sql
        );

        return ModelHydrator::hydrateObjects($this->modelClass, $stdObjects, $columns);
    }

    public function selectById(int $id):Object
    {
        $sql=QuerySqlBuilder::buildSingleSelect($this->table);
        $idColumn=TableSchema::getPrimaryKey($this->table);

        [$stdObject,$columns]=QueryExecutor::executeSelect(
            $this->pdo,
            $sql,
            [$idColumn => $id]
        );

        return ModelHydrator::hydrateObject($this->modelClass, $stdObject,$columns);
    }

    public function insert(array|Request $data):bool 
    {
        $all = $data instanceof Request ? $data->getAll() : $data;
        
        if(!$this->inAllowed($all))
            return false;

        $timestamp = date('Y-m-d H:i:s', time());
        if(TableSchema::createdAtExist($this->table))
            $all=array_merge($all, ["created_at" => $timestamp, "updated_at" => $timestamp]);

        $sql=QuerySqlBuilder::buildInsert($this->table, $all);
        return QueryExecutor::executeNonQuery(
            $this->pdo, 
            $sql, 
            $all
        );
    }

    public function update(int $id, array $values):bool 
    {
        $columns=array_keys($values);
        $timestamp = date('Y-m-d H:i:s', time());
        if(TableSchema::updatedAtExist($this->table))
        {
            $values=array_merge($values, ["updated_at" => $timestamp]);
            $columns=array_merge($columns,["updated_at"]);
        }
            
        $idColumn=TableSchema::getPrimaryKey($this->table);
        $sql=QuerySqlBuilder::buildUpdate($this->table, $idColumn, $columns);

        return QueryExecutor::executeNonQuery(
            $this->pdo, 
            $sql, 
            array_merge([$idColumn => $id], $values)
        );
    }

    public function delete(int $id):bool 
    {
        $idColumn=TableSchema::getPrimaryKey($this->table);
        $sql=QuerySqlBuilder::buildDelete($this->table, $idColumn);

        return QueryExecutor::executeNonQuery(
            $this->pdo, 
            $sql, 
            [$idColumn => $id]
        );
    }

    private function inAllowed(array $data):bool 
    {
        foreach($data as $key => $value)
        {
            if(!in_array($key, $this->allowed))
                return false;
        }
        return true;
    }

}