<?php
use Src\Routing\Route;

require_once "vendor/autoload.php";


//Route::view("/","welcome")
  //  ->name("home");

// Route::get("/","MyController","index2")   
//   ->name("home");

Route::view("/","welcome");

Route::get("/admin/test","MyController","index")
  ->name("admin.testPage");

Route::post("/admin/add-user","MyController","addUser")
  ->name("admin.addUser");

Route::post("/admin/delete/{id}","MyController","delete")
  ->name("admin.deleteUser");

Route::middleware(["Auth","Log"])->prefix("/admin/rnd")->group(function(){

  Route::get("/random","MyController","index")
    ->name("admin.testPage2");

  Route::get("/random2","MyController","index2")
    ->name("admin.addUser2");

});

Route::get("/admin/nesto","MyController","index");



