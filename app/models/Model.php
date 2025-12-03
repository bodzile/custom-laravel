<?php

namespace App\Models;

use App\Http\Requests\Request;
use Src\Database;
use Src\Queries\QueryBuilder;

abstract class Model extends Database
{
    protected static string $table;
    protected static array $allowed;

    //polja koja ce se kreirati kao posebne varijable u child klasi
    protected array $fields;

    public static function query():QueryBuilder
    {
        static::$pdo=static::getConnection();
        return static::createQueryBuilder();
    }

    public static function all():array 
    {
        static::$pdo=static::getConnection();
        return static::createQueryBuilder()->getAll();
    }
    
    public static function create(array|Request $data):bool
    {
        static::$pdo=static::getConnection();
        return static::createQueryBuilder()->create($data);
    }

    public static function find(int $id):Model
    {
        static::$pdo=static::getConnection();
        return static::createQueryBuilder()->getById($id);
    }

    public static function update(int $id, array $values):bool
    {
        static::$pdo=static::getConnection();
        return static::createQueryBuilder()->update($id, $values);
    }

    public function delete():bool
    {
        static::$pdo=static::getConnection();
        return static::createQueryBuilder()->delete((int)$this->id);
    }

    public function save():bool
    {
        static::$pdo=static::getConnection();
        return static::createQueryBuilder()->update((int)$this->id, $this->fields);
    }

    private static function createQueryBuilder()
    {
        return new QueryBuilder(static::$table, static::$pdo, static::class, static::$allowed);
    }

    public function __set($name, $value)
    {
        if(!in_array($name,static::$allowed) && !in_array($name,["id","created_at","updated_at"]))
            return;
        $this->fields[$name]=$value;
    }

    public function __get($name)
    {
        return $this->fields[$name];
    }

}