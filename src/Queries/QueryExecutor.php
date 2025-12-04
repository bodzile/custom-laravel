<?php

namespace Src\Queries;

class QueryExecutor{

    public static function executeSelect(\PDO $pdo, string $sql, array $param=[]):array
    {   
        try 
        {
            $columns=[];
            $stmt=$pdo->prepare($sql);
            $stmt->execute($param);
            for($i=0;$i<$stmt->columnCount();$i++)
            {
                $meta=$stmt->getColumnMeta($i);
                $columns[]=$meta["name"];
            }
            return [$stmt->fetchAll(),$columns];
        }
        catch(\PDOException $e)
        {
            die("QueryExecutor Error: " . $e->getMessage());
            return [];
        }
    }

    public static function executeQuery(\PDO $pdo, string $sql, array $param=[]):array
    {
        try 
        {
            $stmt=$pdo->prepare($sql);
            $stmt->execute($param);
            
            return $stmt->fetchAll();
        }
        catch(\PDOException $e)
        {
            die("QueryExecutor Error: " . $e->getMessage());
            return [];
        }
    }


    public static function executeNonQuery(\PDO $pdo, string $sql, array $param=[]):bool 
    {
        try
        {
            $stmt=$pdo->prepare($sql);
            $stmt->execute($param);

            return $stmt->rowCount() > 0;
        }
        catch(\PDOException $e)
        {
            die("QueryExecutor Error: " . $e->getMessage());
            return false;
        }
    }

}