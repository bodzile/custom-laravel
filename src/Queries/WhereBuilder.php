<?php

namespace Src\Queries;

class WhereBuilder{

    public static function build(array $normalizedParam):array
    {
        $res=[
            "sql" => "",
            "columns" => []
        ];
        $temp=" WHERE ";
        $i=0;
        foreach($normalizedParam as $row)
        {
            if($i>0)
                $temp.=$row["bridge"]. " ";
            
            $i++;
            
            if( in_array(strtolower($row["operator"]),["in","any","between"]) )
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
                    $res["columns"][$newColumn]=$val;
                
                    $j++;
                }
                $temp.=")";
            }
            else
            {
                $temp.=$row["column"] . " " . $row["operator"] . " :" . $row["column"] . " ";
                $res["columns"][$row["column"]]=$row["value"];
            }
                
        }
        $res["sql"]=$temp;
        return $res;
    }

}