<?php

namespace Src\Sessions;


class Session{


    public static function has($session_field):bool
    {
        if(isset($_SESSION[$session_field]))
        {
            return true;
        }
        return false;
    }

    public static function set($session_field,$value,$purpose=""):void
    {
        if($purpose == "singleUse")
        {
            if(is_array($value))
            {
                $value["purpose"]="singleUse";
            }
            else
            {
                $value=array($value,"purpose" => "singleUse");
            }
        }
        $_SESSION[$session_field]=$value;
    }


    public static function get($session_field):mixed
    {
        $value=$_SESSION[$session_field];
        if(isset($_SESSION[$session_field]["purpose"]))
        {
            if($_SESSION[$session_field]["purpose"] == "singleUse")
            {   
                self::unset($session_field);
            }
        }
        return $value;
    }

    public static function unset($session_field):void
    {
        if(isset($_SESSION[$session_field]))
        {
            unset($_SESSION[$session_field]);
        }
    }

    public static function destroy():void
    {
        session_destroy();
    }

}