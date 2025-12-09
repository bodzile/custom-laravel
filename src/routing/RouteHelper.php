<?php

namespace Src\Routing;

class RouteHelper
{
    public static function extractPath(string $path):string
    {
        //input "/neko ime/admin/user", output "/admin/user"
        //input "/projekat/admin/add-user", output "/admin/add-user"
        //prvo split po "/" i onda ici po nizu od indeksa 1 i dodavati "/" i vratiti taj string
        
        $result="";
        $split=explode("/",$path);

        for($i=2;$i<count($split);$i++)
        {
            $result =$result .  "/" . $split[$i];
        }
        
        return $result;
    }

    public static function cutGetFromUrl(string $path)
    {
        return explode("?",$path)[0];
    }

    public static function getValueFromUrl(string $path)
    {
        $temp=explode("/",$path);
        return $temp[count($temp)-1];
    }

    public static function cutValueFromUrl(string $path)
    {
        $result="";
        $temp=explode("/",$path);

        for($i=1;$i<count($temp)-1;$i++)
        {
            $result=$result . "/"  . $temp[$i];
        }

        $result.="/";
        
        return $result;
    }

    public static function cutValueFromUrlBrackets(string $path)
    {
        $result = preg_replace('/\s*\{.*?\}\s*/', ' ', $path);
        $result = trim($result); 
        return $result;
    }

    public static function getValueNameFromUrl(string $path)
    {
        if(preg_match("/\{(.*?)\}/",$path,$matches))
        {
            return $matches[1];
        }
        return null;
    }

    
}