<?php

namespace Src\Errors\Providers;
use Src\Errors\ErrorData;
use Src\Errors\Providers\ErrorProviderInterface;
use Throwable;
use Exception;

class FrameworkExceptionErrorProvider implements ErrorProviderInterface{

    public function support(Throwable $e):bool
    {
        return $e instanceof Exception;
    }
    
    public function build(Throwable $e):ErrorData
    {
        print_r($e); die();
        //print_r($e); die();
    }

}