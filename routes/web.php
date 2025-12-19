<?php
use Src\Routing\Route;

require_once "vendor/autoload.php";


Route::view("/","welcome")->build();

Route::get("/admin/test","MyController","index")
  ->name("admin.testPage")
  ->build();

Route::post("/admin/add-user","MyController","addUser")
  ->name("admin.addUser")
  ->build();

  // /admin/delete/1
Route::get("/delete/{id:MyModel}","MyController","delete")
  ->prefix("/admin")
  ->name("admin.deleteUser")
  ->build();

Route::get("/pull/{s:MyModel}","MyController","showPull")
  ->prefix("/admin")
  ->name("admin.showPull")
  ->build();


Route::middleware(["Auth","Log"])->prefix("/admin/rnd")->group(function(){

  Route::get("/random","MyController","index")
    ->name("admin.testPage2")->build();

  Route::get("/random2","MyController","index2")
    ->name("admin.addUser2")->build();

});
  

Route::get("/admin/nesto","MyController","index")->build();



