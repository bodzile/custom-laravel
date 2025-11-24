<?php

namespace App\Http\Middlewares;

use App\Http\Requests\Request;
use Src\RedirectTrait;

class Auth implements Middleware
{

    use RedirectTrait;

    public static function handle(Request $request, \Closure $next)
    {

        if(1==1)
        {
            return redirect("/admin/test");
               // header("Location: google.com");
             
        }


        return $next($request);
    }
}