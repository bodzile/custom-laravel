<?php

namespace Src\Queries;

class QueryNormalizer{

    public static function normalizeWhere(array $param)
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
        //     ["name", "pera"],
        //     ["number","in",[1,2,3]],
        //     ["diff" , "like","%s"],
        //    ["random" , "<=",3]
        // ]
        $tmp=[];
        foreach($param as $key=>$value)
        {
            $cond=$value;
            if(!is_array($cond))
                $cond=["=",$value];
            $tmp[]=array_merge([$key],$cond);
        }
        return $tmp;
    }

}