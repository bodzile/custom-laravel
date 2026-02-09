<?php

namespace Src\Queries;

use App\Http\Requests\Request;
use App\Models\Model;
use Src\Queries\Repository;
use Src\Queries\QueryValidator;
use Src\Queries\WhereBuilder;
use Src\Queries\QueryParts;

class QueryBuilder
{
    private QueryParts $queryParts;

    public function __construct(
        private string $table, 
        private string $modelClass, 
        private array $allowed
    ){
        $this->queryParts = new QueryParts();
    }


    public function select(array $columns):QueryBuilder 
    {
        QueryValidator::validateAllowedParameters($columns, $this->allowed, $this->table);
        $this->queryParts->select=$columns;

        return $this;
    }

    public function selectRaw(string $sql):QueryBuilder 
    {
        //QueryValidator::validateSelect($this->query);
        $this->queryParts->selectRaw=$sql;
        return $this;
    }

    public function where(array $param):QueryBuilder
    {
        QueryValidator::validateAllowedParameters(array_keys($param), $this->allowed, $this->table);
        $normalizedParam=QueryNormalizer::normalizeWhere($param);

        $this->queryParts->where=WhereBuilder::build($normalizedParam);
        return $this;
    }

    public function sum(string $column):QueryBuilder
    {
        QueryValidator::validateAllowedParameters([$column], $this->allowed, $this->table);
        $this->queryParts->select="SUM($column) ";
        $this->queryParts->aggregates=true;
        return $this;
    }

    public function min(string $column):mixed 
    {
        QueryValidator::validateAllowedParameters([$column], $this->allowed, $this->table);
        return new Repository($this->table,$this->allowed, $this->modelClass)->getAggregateResult($column, "MIN");
    }

    public function max(string $column):mixed 
    {
        QueryValidator::validateAllowedParameters([$column], $this->allowed, $this->table);
        return new Repository($this->table,$this->allowed, $this->modelClass)->getAggregateResult($column, "MAX");
    }

    public function avg(string $column):mixed 
    {
        QueryValidator::validateAllowedParameters([$column], $this->allowed, $this->table);
        return new Repository($this->table,$this->allowed, $this->modelClass)->getAggregateResult($column, "AVG");
    }

    public function groupBy(string $param):QueryBuilder
    {
        $this->queryParts->groupBy=" GROUP BY " . $param;
        return $this;
    }

    public function orderBy(string $param,string $direction="ASC"):QueryBuilder
    {
        $this->queryParts->orderBy=" ORDER BY " . $param . " " . strtoupper($direction) . "";
        return $this;
    }

    public function take(int $param):QueryBuilder
    {
        $this->queryParts->limit=" LIMIT " . $param;
        return $this;
    }

    public function get():array
    {
        return new Repository($this->table,$this->allowed, $this->modelClass)->select($this->queryParts);
    }

    public function getScalar():mixed
    {
        //QueryValidator::validateAggregates($this->query);
        return new Repository($this->table,$this->allowed, $this->modelClass)->selectScalar($this->queryParts);
    }

    public function first():?Model
    {
        $res=new Repository($this->table,$this->allowed, $this->modelClass)->select($this->queryParts);
        if(!empty($res))
            return $res[0];
        return null;
    }


}