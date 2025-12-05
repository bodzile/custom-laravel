<?php
use Routes\Route;
use Routes\RouteHelper;
use Routes\Router;
use App\Http\Requests\Request;
use Src\Pipeline;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "vendor/autoload.php";
require_once "routes/web.php";

return new Router()->route();

