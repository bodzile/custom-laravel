<?php

namespace App\Models;

use App\Http\Requests\Request;
use Src\Queries\QueryBuilder;
use Src\Queries\Repository;

abstract class Model
{
    protected static string $table;
    protected static array $allowed;

    //polja koja ce se kreirati kao posebne varijable u child klasi
    protected array $fields;

    public static function select(...$columns):QueryBuilder
    {
        return static::createQueryBuilder()->select($columns);
    }

    public static function selectRaw(string $sql):QueryBuilder 
    {
        return static::createQueryBuilder()->selectRaw($sql);
    }

    public static function count(string $column):QueryBuilder
    {
        return static::createQueryBuilder()->count($column);
    }

    public static function sum(string $column):QueryBuilder
    {
        return static::createQueryBuilder()->sum($column);
    }

    public static function min(string $column):mixed 
    {
        return static::createQueryBuilder()->min($column);
    }

    public static function max(string $column):mixed 
    {
        return static::createQueryBuilder()->max($column);
    }

    public static function avg(string $column):mixed 
    {
        return static::createQueryBuilder()->avg($column);
    }

    // public static function query():QueryBuilder
    // {
    //     return static::createQueryBuilder();
    // }

    public static function where(array $param):QueryBuilder 
    {
        return static::createQueryBuilder()->where($param);
    }

    public static function all():array 
    {
        return static::createRepository()->selectAll(static::$table, static::class);
    }
    
    public static function create(array|Request $data):bool
    {
        return static::createRepository()->insert($data);
    }

    public static function find(int $id):?Model
    {
        return static::createRepository()->selectById($id);
    }

    public static function update(int $id, array $values):bool
    {
        return static::createRepository()->update($id, $values);
    }

    public function delete():bool
    {
        return static::createRepository()->delete((int)$this->id);
    }

    public function save():bool
    {
        return static::createRepository()->update((int)$this->id, $this->fields);
    }

    private static function createRepository()
    {
        return new Repository(static::$table, static::$allowed, static::class);
    }

    private static function createQueryBuilder()
    {
        return new QueryBuilder(static::$table, static::class, static::$allowed);
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