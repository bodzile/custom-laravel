<?php

namespace Src\Errors\Providers;

use Throwable;
use Src\Errors\ErrorData;

interface ErrorProviderInterface{

    public function support(Throwable $e):bool;
    public function build(Throwable $e):ErrorData;

}