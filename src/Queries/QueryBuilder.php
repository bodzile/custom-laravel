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
    //private string $modelClass;

    private array $query=[
        "where" => [
            "columns" => [],
            "sql" => ""
        ],
        "groupBy" => "",
        "orderBy" => "",
        "limit" => 0
    ];

    public function __construct(string $table,\PDO $pdo,array $allowed)
    {
        $this->table=$table;
        $this->pdo=$pdo;
        $this->allowed=$allowed;
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

    public function get():array
    {
        [$sql,$param]=QuerySqlBuilder::buildSelect($this->table,$this->query);
        return QueryExecutor::executeSelect($this->pdo, $sql, $param);
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
        $sql=QuerySqlBuilder::buildDelete($this->table, $id);
        return QueryExecutor::executeNonQuery($this->pdo, $sql, ["id" => "id"]);
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

}