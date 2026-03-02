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


//Route::prefix("/c2")->name("c6.aa")->group(function(){++
//    Route::view("/contact2","welcome")->build();
//});




Route::middleware(["Auth","Log"])->name("admin.")->prefix("/admin/rnd1")->group(function(){

  Route::get("/random","MyController","index")->prefix("/prefix")
    ->name("testPage2")->build();

  Route::get("/random2","MyController","index2")
    ->name("addUser2")->build();

  Route::prefix("/c")->name("a2.")->group(function(){
      Route::view("/contact","contact")->name("Contact")->build();

      Route::prefix("/c2")->name("a3.")->group(function(){
          Route::view("/kontakt-forma","contact")->name("kontakt-forma")->build();
      });

      Route::view("/nova-ruta","contact")->name("Contact2")->build();

  });

    Route::view("/random3", "contact")->name("contact")->build();

});
  

Route::get("/admin/nesto","MyController","index")->build();



