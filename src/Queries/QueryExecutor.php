<?php

namespace Src\Queries;

use PDO;

class QueryExecutor{

    public static function executeSelect(PDO $pdo, string $sql, array $param=[]):array
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

    public static function executeQuery(PDO $pdo, string $sql, array $param=[]):array
    {
        $stmt=$pdo->prepare($sql);
        $stmt->execute($param);
        
        return $stmt->fetchAll();
    }


    public static function executeNonQuery(PDO $pdo, string $sql, array $param=[]):bool 
    {
        $stmt=$pdo->prepare($sql);
        $stmt->execute($param);

        return $stmt->rowCount() > 0;
    }

}