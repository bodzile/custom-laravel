<?php

namespace Src\Errors;

use Src\Errors\ErrorData;

class ErrorDataResolver{


    public static function resolve(ErrorData $data):void
    {
        extract([$data]);
        require_once  "Views/BaseErrorView.php";
        die();
        exit;
    }


}