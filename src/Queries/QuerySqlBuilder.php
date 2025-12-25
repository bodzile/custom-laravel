<?php

namespace Src\Queries;

class QuerySqlBuilder{

    public static function buildSelect(string $table, array $query):array
    {
        $sql="SELECT * from $table";
        $param=[];

        foreach($query as $key => $value)
        {
            if(!empty($value))
            {
                if($key == "where")
                {
                    $sql.=$value["sql"];
                    foreach($value["columns"] as $column => $columnValue)
                    {
                        $param[$column] = $columnValue;
                    }
                }
                    
                else
                    $sql.=$value;
            }
        }
        $sql.=";";

        return [$sql,$param];
    }

    public static function buildSelectAll(string $table):string
    {
        return "SELECT * from $table";
    }

    public static function buildSingleSelect(string $table, string $idColumn):string
    {
        return "SELECT * from $table WHERE $idColumn=:$idColumn";
    }

    public static function buildInsert(string $table, array $data):string 
    {
        $sql="INSERT INTO ";
        $columns=" (";
        $values="VALUES (";
        $param=[];
        
        $i=0;
        foreach($data as $column => $value)
        {
            if($i>0)
            {
                $columns.=", ";
                $values.=", ";
            }
                
            $columns.=$column;
            $values.=":" . $column; 
            $i++;
        }
        $columns.=") ";
        $values.=");";

        $sql.= $table . $columns  . $values;

        return $sql;
    }

    public static function buildDelete(string $table, string $idColumn):string 
    {
        return "DELETE from $table WHERE $idColumn=:$idColumn";
    }

    public static function buildUpdate(string $table, string $idColumn, array $columns):string 
    {
        for($i=0;$i<count($columns);$i++)
        {
            $columns[$i]= $columns[$i] . "=:$columns[$i]";
        }
        $temp=implode(",",$columns);
        //die($temp);
        
        $sql="UPDATE $table SET $temp WHERE $idColumn=:$idColumn";
        return $sql;
    }

    public static function buildDescribe(string $table):string 
    {
        return "DESCRIBE $table";
    }

}
