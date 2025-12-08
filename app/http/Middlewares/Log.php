<?php

namespace App\Http\Middlewares;

use App\Http\Requests\Request;
use Src\RedirectTrait;

class Log implements Middleware
{

    use RedirectTrait;

    public static function handle(Request $request, \Closure $next)
    {

        if(1==2)
        {

            return $this->redirect("/");
               // header("Location: google.com");
             
        }


        return $next($request);
    }
}