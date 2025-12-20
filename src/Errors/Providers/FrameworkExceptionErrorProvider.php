<?php

namespace Src\Errors\Providers;
use Src\Errors\ErrorData;
use Src\Errors\Providers\ErrorProviderInterface;
use Src\Exceptions\FrameworkException;
use Src\Adapters\ErrorDataAdapter;
use Throwable;


class FrameworkExceptionErrorProvider implements ErrorProviderInterface{

    public function support(Throwable $e):bool
    {
        return $e instanceof FrameworkException;
    }
    
    public function build(Throwable $e):ErrorData
    {
        //print_r(get_class($e)); die();
        $instanceSplit=explode("\\", get_class($e));
        $instance=$instanceSplit[array_key_last($instanceSplit)];
        //die($instance);
        $errorData=ErrorDataAdapter::find($instance);
        if(!$errorData)
            return new ErrorData(900, "Unknown erro data","");

        print_r($errorData); die();

        return new ErrorData(
            $errorData->status_code,
            $errorData->title,
            $errorData->description
        );
        
    }

}