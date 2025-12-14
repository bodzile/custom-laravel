<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Models\MyModel;

class MyController extends Controller
{
    public function index(Request $request)
    {
        //$users=MyModel::create(["name" => "barbel row", "difficulty" => "medium", "type" => "ledja"]);


        //trebalo bi da vrati ili objekat ili niz objekata instance MyModel ili Model da mogu da se setuju polja
        $users=MyModel::query()->where(["difficulty" => "easy"])->get();

        $user=MyModel::find(6);

        //print_r($user); die();

        // echo $user->id . "<br>";
        // echo $user->name . "<br>";
        // echo $user->difficulty . "<br>";

        // $user->name="novo";
        // $user->difficulty="hard";
        // $user->save();

        // echo $user->id . "<br>";
        // echo $user->name . "<br>";
        // echo $user->difficulty . "<br>";

        echo "--------------------------";

        //$user->delete();

        // MyModel::update($users->id,[
        //     "name" => "mikara",
        //     "type" => "rame"
        // ]);


        return $this->view("test",compact("users"));
    }

    public function index2()
    {
        $name="pera";

        return $this->view("welcome",compact("name"));
    }

    public function addUser(Request $request)
    {
        //$request->validate();
        //die("poz");

        $this->redirect()->back()->with("success","uspesno ste poslali");
    }

    public function delete(Request $request, $id)
    {
        die($id);
    }

    public function rnd()
    {
        echo "rnd";
    }
}