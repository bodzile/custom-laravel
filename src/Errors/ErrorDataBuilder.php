<?php

namespace Src\Errors;

use Src\Errors\ErrorData;

use Throwable;


class ErrorDataBuilder{

    final static string $providerPrefix="Src\\Errors\\Providers\\";

    private static array $providers=[
        "PhpErrorProvider",
        "FrameworkExceptionErrorProvider"
    ];

    public static function build(Throwable $e):ErrorData
    {
        $errorData=new ErrorData();
        foreach(ErrorDataBuilder::$providers as $providerName)
        {
            $providerClass=ErrorDataBuilder::$providerPrefix . $providerName;
            $provider=new $providerClass;
            if($provider->support($e))
            {
                $errorData=$provider->build($e);
            }
        }
        return $errorData;
    }

}