<?php

namespace Src\Queries;

use App\Http\Requests\Request;
use App\Models\Model;
use Src\Queries\Repository;

class QueryBuilder
{

    private array $query=[
        "where" => [
            "columns" => [],
            "sql" => ""
        ],
        "groupBy" => "",
        "orderBy" => "",
        "limit" => 0
    ];

    public function __construct(
        private string $table, 
        private string $modelClass, 
        private array $allowed
    ){}

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
        return new Repository($this->table,$this->allowed, $this->modelClass)->select($this->query);
    }


}