<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Src\Routing\Router;
use Src\Errors\ErrorHandler;

require_once "vendor/autoload.php";
require_once "routes/web.php";

try
{
    $router=new Router();
    $router->validate();
    $router->route();
}
catch(Throwable $e)
{
    ErrorHandler::handle($e);
}


