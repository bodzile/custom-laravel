<?php

namespace Src\Errors\Providers;
use Src\Errors\Providers\ErrorProviderInterface;
use Src\Errors\ErrorData;
use Throwable;
use Error;

class PhpErrorProvider implements ErrorProviderInterface {
    
    public function support(Throwable $e):bool
    {
        return $e instanceof Error;
    }
    
    public function build(Throwable $e):ErrorData
    {
        print_r($e); die();
    }

}