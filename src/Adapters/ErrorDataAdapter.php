<?php

namespace Src\Adapters;

use App\Models\Model;
use Src\Models\ErrorModel;

class ErrorDataAdapter{

    public static function find(string $exceptionClassName):?ErrorModel 
    {
        return ErrorModel::query()->where(["exception_name" => $exceptionClassName])->first();
    }

}