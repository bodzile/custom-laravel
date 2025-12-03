<?php

namespace Src\Queries;

use Src\Queries\QueryExecutor;
use Src\Queries\QuerySqlBuilder;
use App\Http\Requests\Request;

class QueryBuilder
{

    private string $table;
    private \PDO $pdo;
    private array $allowed;
    private string $modelClass;

    private array $query=[
        "where" => [
            "columns" => [],
            "sql" => ""
        ],
        "groupBy" => "",
        "orderBy" => "",
        "limit" => 0
    ];

    public function __construct(string $table,\PDO $pdo,string $modelClass,array $allowed)
    {
        $this->table=$table;
        $this->pdo=$pdo;
        $this->allowed=$allowed;
        $this->modelClass=$modelClass;
    }

    public function where(array $param):QueryBuilder
    {
        $temp=" WHERE ";
        $i=0;
        foreach($param as $column => $value)
        {
            if(!in_array($column,$this->allowed))
                throw new \Exception("Column is not inside allowed array");
            if($i>0)
                $temp.="AND ";
            $temp.=$column . "=:" . $column . " ";
            $i++;
            $this->query["where"]["columns"][$column]=$value;
        }
        $this->query["where"]["sql"]=$temp;

        //die(get_class($this));

        return $this;
    }

    public function groupBy(string $param):QueryBuilder
    {
        $this->query["groupBy"]=" GROUP BY " . $param;

        return $this;
    }

    public function orderBy(string $param,string $direction="ASC"):QueryBuilder
    {
        $this->query["orderBy"]=" ORDER BY " . $param . " " . strtoupper($direction) . "";

        return $this;
    }

    public function take(int $param):QueryBuilder
    {
        $this->query["limit"]=" LIMIT " . $param;

        return $this;
    }

    public function get():array|Object
    {
        [$sql,$param]=QuerySqlBuilder::buildSelect($this->table,$this->query);
        [$stdObjects,$columns]=QueryExecutor::executeSelect($this->pdo, $sql, $param);

        $res=$this->getModelObjects($stdObjects,$columns);

        return $res;
    }

    public function create(array|Request $data):bool 
    {
        $all = $data instanceof Request ? $data->getAll() : $data;
        
        if(!$this->inAllowed($all))
            return false;

        $sql=QuerySqlBuilder::buildInsert($this->table, $all);
        return QueryExecutor::executeNonQuery($this->pdo, $sql, $all);
    }

    public function delete(int $id):bool 
    {
        $sql=QuerySqlBuilder::buildDelete($this->table);
        return QueryExecutor::executeNonQuery($this->pdo, $sql, ["id" => $id]);
    }

    public function update(int $id, array $values):bool 
    {
        $sql=QuerySqlBuilder::buildUpdate($this->table, array_keys($values));
        return QueryExecutor::executeNonQuery($this->pdo, $sql, array_merge(["id" => $id], $values));
    }

    private function inAllowed(array $data):bool
    {
        foreach($data as $key => $value)
        {
            if(!in_array($key,$this->allowed))
                return false;
        }
        return true;
    }

    private function getModelObjects(array $stdObjects, array $columns):array|Object 
    {
        if(count($stdObjects) == 1)
        {
            $modelObj=new $this->modelClass;
            foreach($columns as $column)
            {
                $modelObj->$column=$stdObjects[0]->$column;
            }
            return $modelObj;
        }

        $res=[];
        foreach($stdObjects as $obj)
        {
            $modelObj=new $this->modelClass;
            foreach($columns as $column)
            {
                $modelObj->$column=$obj->$column;
            }
            $res[]=$modelObj;
        }

        return $res;
    }

}