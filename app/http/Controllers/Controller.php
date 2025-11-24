<?php

namespace App\Http\Controllers;

use Src\Redirect;
use Src\RedirectTrait;
use Src\Sessions\Session;

abstract class Controller
{
    use RedirectTrait;
    //funckija ucitava view i ucitava podatke
    public function view($view,$data=[]):void
    {
        //extract otpakuje sve podatke
        extract($data);
        require_once "resources/views/{$view}.php";
    }


}