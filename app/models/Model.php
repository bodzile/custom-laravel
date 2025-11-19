<?php

namespace App\Models;

use App\Http\Requests\Request;
use Src\Database;

abstract class Model
{
    //trait
    use Database;
    protected static string $table;
    
    
    //funckija all vraca sve redove iz definisane tabele
    public static function all():array
    {
        static::getConnection();
        
        $command_text="SELECT * from `" . static::$table . "`";
        $result=static::$conn->query($command_text);
        
        $rows=$result->fetch_all(MYSQLI_ASSOC);

        static::$conn->close();

        return $rows;
    }

    //dinamicni query za where, unutar param niza se unose svi parametri koji su potrebni za jednakost u where
    public static function where($param=[]):array
    {
        static::getConnection();
        $table_value=static::$table;

        $where_clausule=" where ";
        foreach($param as $key => $value)
        {
            $where_clausule = $where_clausule . " " . $key . "='" . $value . " ";
        }

        $command_text="SELECT * from `" . static::$table . $where_clausule . "`";
        $result=static::$conn->query($command_text);
        
        $rows=$result->fetch_all(MYSQLI_ASSOC);

        static::$conn->close();

        return $rows;
    }

    //funkcija vraca sve redove u kojima je where $column like $value
    public static function whereLike($column,$value)
    {

    }

    //vraca jedan red iz baze po id-u
    public static function find($id):array
    {
        static::getConnection();

        $command_text="SELECT * from `" . static::$table . "` where id=?";
        $query=static::$conn->prepare($command_text);
        $query->bind_param("i",$id);

        $query->execute();
        $result=$query->get_result();
        $row=$result->fetch_assoc();
        $query->close();

        static::closeConnection();

        return $row;
    }

    public static function create(Request|array $param):void
    {
        $values=[];


        if($param instanceof Request)
        {
        
        }
        else
        {
            $values=$param;
        }
    
    }

}