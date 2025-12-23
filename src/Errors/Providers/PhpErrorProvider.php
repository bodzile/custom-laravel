<?php

namespace Src\Errors\Providers;
use Src\Errors\Providers\ErrorProviderInterface;
use Src\Errors\ErrorData;
use Throwable;
use Error;
use ReflectionClass;

class PhpErrorProvider implements ErrorProviderInterface {
    
    public function support(Throwable $e):bool
    {
        return $e instanceof Error;
    }
    
    public function build(Throwable $e):ErrorData
    {
        $className=(new ReflectionClass($e))->getShortName();
        $message=$e->getMessage();
        $line=(string)$e->getLine();
        $file=$e->getFile();
        $stackTrace=$e->getTraceAsString();

        $description="<b style='color:white'>$className</b> | $message <br> <b style='color:white'>File:</b> $file , <b style='color:white'>line:</b> $line <br> <b style='color:white'>Trace:</b> $stackTrace";

        return new ErrorData(
            500,
            "PHP",
            $description
        );   
    }

}