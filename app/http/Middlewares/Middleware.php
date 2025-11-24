<?php

namespace App\Http\Middlewares;

use App\Http\Requests\Request;

interface Middleware{

    public static function handle(Request $request,\Closure $next);

}