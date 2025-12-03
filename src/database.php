<?php

namespace Src;

class Database
{
    public static \PDO $pdo;
    //cela klasa sluzi samo da bi na jednom mestu definisali podatke o bazi
    private static array $db_info=[
        "host" => "localhost",
        "username" => "root",
        "password" => "",
        "db_name" => "crud-vezbanje"
    ];

    protected static array $options=[
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ];

    public static function getConnection():\PDO
    {
        if(!isset(self::$pdo))
        {
            $dsn="mysql:host=" . static::$db_info["host"] . ";dbname=" . static::$db_info["db_name"] . ";charset=utf8mb4";
            static::$pdo=new \PDO(
                $dsn,
                static::$db_info["username"],
                static::$db_info["password"],
                static::$options
            );
        }
        return self::$pdo;
    }

    
}