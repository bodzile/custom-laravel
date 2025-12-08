<?php

use Src\Routing\Router;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "vendor/autoload.php";
require_once "routes/web.php";

$router=new Router();
$router->validate();
$router->route();

