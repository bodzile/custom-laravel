<?php
use Src\Routing\Route;

require_once "vendor/autoload.php";


//Route::view("/","welcome")
  //  ->name("home");

// Route::get("/","MyController","index2")   
//   ->name("home");


Route::middleware("rnd")->view("/","welcome")->build();

Route::get("/admin/test","MyController","index")
  ->name("admin.testPage")
  ->build();

Route::post("/admin/add-user","MyController","addUser")
  ->name("admin.addUser")
  ->build();

  // /admin/delete/1
Route::post("/delete/{id}","MyController","delete")
  ->prefix("/admin")
  ->name("admin.deleteUser")
  ->build();



Route::middleware(["Auth","Log"])->prefix("/admin/rnd")->group(function(){

  Route::get("/random","MyController","index")
    ->name("admin.testPage2")->build();

  Route::get("/random2","MyController","index2")
    ->name("admin.addUser2")->build();

});
  

Route::get("/admin/nesto","MyController","index")->build();

foreach(Route::$routes as $route)
{
   print_r($route); echo "<br>";
}
die();



