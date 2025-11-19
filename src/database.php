<?php

namespace Src;

trait Database
{
    public static \mysqli $conn;
    //cela klasa sluzi samo da bi na jednom mestu definisali podatke o bazi
    public static $db_info=[
        "host" => "localhost",
        "username" => "root",
        "password" => "",
        "db_name" => "crud-vezbanje"
    ];

    public static function getConnection():void
    {
        if(!isset(self::$conn))
        {
            $db=Database::$db_info;
            static::$conn=new \mysqli(
                $db["host"],
                $db["username"],
                $db["password"],
                $db["db_name"]
            );
        }
    }

    public static function closeConnection():void
    {
        //if(isset(self::$conn))
            //Database::$conn->close();
    }
    
}