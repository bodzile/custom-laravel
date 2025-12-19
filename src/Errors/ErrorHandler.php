<?php

namespace Src\Errors;

use Src\Errors\ErrorData;
use Src\Errors\ErrorDataBuilder;
use Src\Errors\ErrorDataResolver;
use Throwable;

class ErrorHandler{

    public static function handle(Throwable $e):void
    {
        $errorData=ErrorDataBuilder::build($e);
        ErrorDataResolver::resolve($errorData);
    }

}