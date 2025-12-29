<?php

namespace Src\Queries;

use App\Http\Requests\Request;
use App\Models\Model;
use Src\Queries\Repository;
use Src\Queries\QueryValidator;

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

        QueryValidator::validateAllowedParameters(array_keys($param), $this->allowed, $this->table);
        $param=QueryNormalizer::normalizeWhere($param);
        //print_r($param); die();
        
        foreach($param as $array)
        {
            if($i>0)
                $temp.="AND ";

            $value=$array[2];
            // if(is_array($value))
            //     $valueS

            $temp.=$array[0] . " " . $array[1] . " :" . $array[0] . " ";
            $i++;
            $this->query["where"]["columns"][$array[0]]=$value;
        }
        $this->query["where"]["sql"]=$temp;

        //print_r($this->query["where"]); die();

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