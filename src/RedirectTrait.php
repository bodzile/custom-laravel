<?php

namespace Src;

use Src\Sessions\Session;

trait RedirectTrait{

    public function redirect($path="")
    {
        if($path != "")
        {
            header("Location: " . $path);
        }   
        return $this;
    }

    public function back()
    {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return $this;
    }

    public function with($variable,$message)
    {
        Session::set($variable,["message" => $message],"singleUse");
        return $this;
    }

}