<?php

namespace Src\Queries;

use Src\Queries\QueryBuilder;
use Src\Queries\ModelHydrator;
use Src\Queries\QuerySqlBuilder;
use Src\Queries\QueryExecutor;
use Src\Database;
use App\Http\Requests\Request;

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
        $sql="SELECT * from $this->table";
        [$stdObjects,$columns]=QueryExecutor::executeSelect(
            $this->pdo, 
            $sql
        );

        return ModelHydrator::hydrateObjects($this->modelClass, $stdObjects, $columns);
    }

    public function selectById(int $id):Object
    {
        $sql=QuerySqlBuilder::buildSingleSelect($this->table);
        [$stdObject,$columns]=QueryExecutor::executeSelect(
            $this->pdo,
            $sql,
            ["id" => $id]
        );

        $res= ModelHydrator::hydrateObject($this->modelClass, $stdObject,$columns);

        return $res;
    }

    public function insert(array|Request $data):bool 
    {
        $all = $data instanceof Request ? $data->getAll() : $data;
        
        if(!$this->inAllowed($all))
            return false;

        $sql=QuerySqlBuilder::buildInsert($this->table, $all);
        return QueryExecutor::executeNonQuery(
            $this->pdo, 
            $sql, 
            $all
        );
    }

    public function update(int $id, array $values):bool 
    {
        $sql=QuerySqlBuilder::buildUpdate($this->table, array_keys($values));
        return QueryExecutor::executeNonQuery(
            $this->pdo, 
            $sql, 
            array_merge(["id" => $id], $values)
        );
    }

    public function delete(int $id):bool 
    {
        $sql=QuerySqlBuilder::buildDelete($this->table);
        return QueryExecutor::executeNonQuery(
            Database::getConnection(), 
            $sql, 
            ["id" => $id]
        );
    }

}