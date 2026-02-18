<?php

namespace Src\Queries;

use App\Http\Requests\Request;
use Src\Models\ModelHydrator;
use Src\Queries\QueryBuilder;
use Src\Queries\QuerySqlBuilder;
use Src\Queries\QueryExecutor;
use Src\Queries\TableSchema;
use Src\Database;
use Src\Exceptions\RecordNotFoundException;
use Src\Exceptions\ColumnNotFoundinAllowedException;
use Src\Exceptions\DeleteFailedException;
use Src\Exceptions\InsertFailedException;
use Src\Exceptions\UpdateFailedException;
use PDO;


class Repository{

    private PDO $pdo;

    public function __construct(
        private string $table,
        private array $allowed,
        private string $modelClass
    ){
        $this->pdo=Database::getConnection();
    }

    public function select(QueryParts $queryParts):array
    {
        [$sql,$param]=QuerySqlBuilder::buildSelect($this->table,$queryParts);

        [$stdObjects,$columns]=QueryExecutor::executeSelect(
            $this->pdo, 
            $sql, 
            $param
        );
        
        if(!$stdObjects)
            throw new RecordNotFoundException;

        return ModelHydrator::hydrateObjects($this->table, $this->modelClass, $stdObjects, $columns);
    }

    public function selectScalar(QueryParts $queryParts):mixed
    {
        [$sql,$param]=QuerySqlBuilder::buildSelect($this->table,$queryParts);

//        $stdObjects=QueryExecutor::executeQuery(
//            $this->pdo,
//            $sql,
//            $param
//        );
//
//        if(!$stdObjects)
//            throw new RecordNotFoundException;

        $res=QueryExecutor::executeQuery($this->pdo, $sql,  $param);
        print_r($res[0]->result); die();

        return $res[0]->result;
    }

    public function selectAll():array
    {
        $sql=QuerySqlBuilder::buildSelectAll($this->table);
        [$stdObjects,$columns]=QueryExecutor::executeSelect(
            $this->pdo, 
            $sql
        );
        if(!$stdObjects)
            throw new RecordNotFoundException;

        return ModelHydrator::hydrateObjects($this->modelClass, $stdObjects, $columns);
    }

    public function selectById(int $id):?Object
    {
        
        $idColumn=TableSchema::getPrimaryKey($this->table);
        $sql=QuerySqlBuilder::buildSingleSelect($this->table, $idColumn);

        [$stdObject,$columns]=QueryExecutor::executeSelect(
            $this->pdo,
            $sql,
            [$idColumn => $id]
        );
        if(!$stdObject)
            throw new RecordNotFoundException;

        return ModelHydrator::hydrateObject($this->modelClass, $stdObject,$columns);
    }

    public function insert(array|Request $data):void 
    {
        $all = $data instanceof Request ? $data->getAll() : $data;
        
        if(!$this->inAllowed($all))
            throw new ColumnNotFoundinAllowedException;

        $timestamp = date('Y-m-d H:i:s', time());
        if(TableSchema::createdAtExist($this->table))
            $all=array_merge($all, ["created_at" => $timestamp, "updated_at" => $timestamp]);

        $sql=QuerySqlBuilder::buildInsert($this->table, $all);
        $res= QueryExecutor::executeNonQuery(
            $this->pdo, 
            $sql, 
            $all
        );
        if(!$res)
            throw new InsertFailedException;
    }

    public function update(int $id, array $values):void 
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

        $res=QueryExecutor::executeNonQuery(
            $this->pdo, 
            $sql, 
            array_merge([$idColumn => $id], $values)
        );
        if(!$res)
            throw new UpdateFailedException;
    }

    public function delete(int $id):void 
    {
        $idColumn=TableSchema::getPrimaryKey($this->table);
        $sql=QuerySqlBuilder::buildDelete($this->table, $idColumn);

        $res=QueryExecutor::executeNonQuery(
            $this->pdo, 
            $sql, 
            [$idColumn => $id]
        );
        if(!$res)
            throw new DeleteFailedException;
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

    public function getAggregateResult(string $column, string $function):mixed
    {
        $sql=QuerySqlBuilder::buildAggregate($this->table, $column, $function);
        $res=QueryExecutor::executeQuery($this->pdo, $sql);

        return $res[0]->result;
    }

}