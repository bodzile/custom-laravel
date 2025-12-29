<?php

namespace Src\Errors\Providers;

use Src\Errors\ErrorData;
use Src\Errors\Providers\ErrorProviderInterface;
use Src\Exceptions\FrameworkException;
use Src\Adapters\ErrorDataAdapter;
use ReflectionClass;
use Throwable;

class FrameworkExceptionErrorProvider implements ErrorProviderInterface{

    public function support(Throwable $e):bool
    {
        return $e instanceof FrameworkException;
    }
    
    public function build(Throwable $e):ErrorData
    {
        
        $exceptionName=(new ReflectionClass($e))->getShortName();
        //print_r($e); die();
        $errorData=ErrorDataAdapter::find($exceptionName);
        
        if(!$errorData)
            return new ErrorData(900, "Unknown erro data","");

        return new ErrorData(
            $errorData->status_code,
            $errorData->title,
            $errorData->description
        );   
    }

}