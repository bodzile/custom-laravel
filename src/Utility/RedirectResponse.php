<?php

namespace Src\Utility;

use Src\Sessions\Session;

class RedirectResponse
{
    public function redirect($path="")
    {
        if($path != "")
        {
            header("Location: " . root() .  $path);
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