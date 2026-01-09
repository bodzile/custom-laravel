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
        
        foreach($param as $row)
        {
            if($i>0)
                $temp.=$row["bridge"]. " ";
            
            $i++;
            
            if( in_array(strtolower($row["operator"]),["in","any"]) )
            {
                $j=0;
                $temp.=$row["column"] . " " . $row["operator"] . " (";
                foreach($row["value"] as $val)
                {
                    $comma="";
                    if($j>0)
                        $comma=",";

                    $newColumn=$row["column"] . "_" . $j ;
                    $temp.=$comma . ":" . $newColumn ;  
                    $this->query["where"]["columns"][$newColumn]=$val;
                
                    $j++;
                }
                $temp.=")";
                
                // print_r($this->query["where"]); die();
            }
            else
            {
                $temp.=$row["column"] . " " . $row["operator"] . " :" . $row["column"] . " ";
                $this->query["where"]["columns"][$row["column"]]=$row["value"];
            }
                
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