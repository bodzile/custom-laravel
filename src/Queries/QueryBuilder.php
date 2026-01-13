<?php

namespace Src\Queries;

use App\Http\Requests\Request;
use App\Models\Model;
use Src\Queries\Repository;
use Src\Queries\QueryValidator;
use Src\Queries\WhereBuilder;

class QueryBuilder
{

    private array $query=[
        "select" => [],
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


    public function select(array $columns):QueryBuilder 
    {
        QueryValidator::validateAllowedParameters($columns, $this->allowed, $this->table);
        $this->query["select"]=$columns;

        return $this;
    }

    public function where(array $param):QueryBuilder
    {
        QueryValidator::validateAllowedParameters(array_keys($param), $this->allowed, $this->table);
        $normalizedParam=QueryNormalizer::normalizeWhere($param);

        $this->query["where"]=WhereBuilder::build($normalizedParam);
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

    public function first():?Model
    {
        $res=new Repository($this->table,$this->allowed, $this->modelClass)->select($this->query);
        if(!empty($res))
            return $res[0];
        return null;
    }


}