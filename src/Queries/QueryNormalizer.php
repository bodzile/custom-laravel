<?php

namespace Src\Queries;

use Exception;

class QueryNormalizer{

    public static function normalizeWhere(array $param):array
    {
        // input: 
        // [
        //     "name" => "pera",
        //     "number" => ["in",[1,2,3]],
        //     "diff" => ["like","%s"],
        //     "random" => ["<=",3]
        // ]
        // output:
        // [
        //     [
        //          "column" => "name",
        //          "operator" => "=",
        //          "value" => "pera",
        //          "bridge" => "AND"
        //     ],
        //          "column" => "number",
        //          "operator" => "in"
        //          "value" => [1,2,3],
        //          "bridge" => "AND"
        //     ],
        //          "column" => "diff",
        //          "operator" => "like",
        //          "value" => "%s",
        //          "bridge" => "AND"
        //     ],
        //          "column" => "random",
        //          "operator" => "<=",
        //          "value" => "3",
        //          "bridge" => "AND"
        //     ],
        // ]
        $res=[];
        foreach($param as $key=>$value)
        {
            $operator="=";
            $extractedValue=$value;
            if(is_array($value))
            {
                if(count($value)<2)
                    throw new Exception;
                $operator=$value[0];
                $extractedValue=$value[1];
            }

            $tmp=[
                "column" => $key,
                "operator" => $operator,
                "value" => $extractedValue,
                "bridge" => "AND",
            ];

            $res[]=$tmp;
        }
        return $res;
    }

}