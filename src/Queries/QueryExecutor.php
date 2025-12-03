<?php

namespace Src\Queries;

class QueryExecutor{

    public static function executeSelect(\PDO $pdo, string $sql, array $param):array
    {   
        try 
        {
            $stmt=$pdo->prepare($sql);
            $stmt->execute($param);
            return $stmt->fetchAll();
        }
        catch(\PDOException $e)
        {
            error_log("QueryExecutor Error: " . $e->getMessage());
            return [];
        }
    }

    public static function executeNonQuery(\PDO $pdo, string $sql, array $param):bool 
    {
        try
        {
            $stmt=$pdo->prepare($sql);
            $stmt->execute($param);

            return $stmt->rowCount() > 0;
        }
        catch(\PDOException $e)
        {
            error_log("QueryExecutor Error: " . $e->getMessage());
            return false;
        }
    }


    

}