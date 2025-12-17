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

    public static function getRouteParamNameFromUrl(string $path):array|string
    {
        if(preg_match("/\{(.*?)\}/",$path,$matches))
        {
            if(str_contains($matches[1],":"))
            {
                return explode(":", $matches[1]);
            }
            return $matches[1];
        }
        return "";
    }

    public static function containRouteParamInUrl(string $path):bool
    {
        if (preg_match('/\{[^}]+\}/', $path))
            return true;
        return false;
    }

    public static function matchRouteParam(string $url, string $routeUrl):bool 
    {
        $urlSplit=explode("/",$url);
        $routeUrlSplit=explode("/",$routeUrl);

        if(count($urlSplit) != count($routeUrlSplit) || empty($urlSplit[count($urlSplit)-1]))
            return false;

        $j=0;
        for($i=0;$i<count($routeUrlSplit);$i++)
        {
            if(preg_match('/^\{[^}]+\}$/',$routeUrlSplit[$i]))
            {
                $j=$i;
            }
        }
        unset($routeUrlSplit[$j]);
        unset($urlSplit[$j]);
        $routeUrlSplit=array_values($routeUrlSplit);
        $urlSplit=array_values($urlSplit);

        if($routeUrlSplit === $urlSplit)
            return true;
            
        return false;
    }

    public static function getRouteParamValue(string $url, string $routeUrl):string
    {
        $urlSplit=explode("/",$url);
        $routeUrlSplit=explode("/",$routeUrl);

        $j=0;
        for($i=0;$i<count($routeUrlSplit);$i++)
        {
            if(preg_match('/^\{[^}]+\}$/',$routeUrlSplit[$i]))
            {
                $j=$i;
            }
        }

        return $urlSplit[$j] ?? "";
    }

    public static function getRouteParamMetadata(string $routeUrl):array
    {
        $params=[];
        if(RouteHelper::containRouteParamInUrl($routeUrl))
        {
            $param=RouteHelper::getRouteParamNameFromUrl($routeUrl);
            $params= [
                (string)$param[0] => $param[1]
            ];
        }
        return $params;
    }
    
}