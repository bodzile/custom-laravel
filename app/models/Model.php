<?php

namespace App\Models;

use App\Http\Requests\Request;
use Src\Database;
use Src\Queries\QueryBuilder;

abstract class Model extends Database
{
    protected static string $table;
    protected static array $allowed;


    public static function query():QueryBuilder
    {
        static::$pdo=static::getConnection();
        return new QueryBuilder(static::$table,static::$pdo,static::$allowed);
    }
    
    public static function create(array|Request $data):bool
    {
        static::$pdo=static::getConnection();
        return new QueryBuilder(static::$table,static::$pdo,static::$allowed)->create($data);
    }

}