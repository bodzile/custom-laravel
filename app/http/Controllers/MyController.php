<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Models\MyModel;

class MyController extends Controller
{
    public function index(Request $request)
    {

        //require_once "database/migrations/migration1.php";

        $users = MyModel::where([
            "name" => ["like", "%s%"],
        ])->get();

        //$res = MyModel::sum("id")->where(["id" => ["in", [13, 15]]])->getScalar();

        view("test", compact("users"));

        //$user=MyModel::find(100);
        //print_r($res); die();

        //print_r($user); die();

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

    public function delete(Request $request, MyModel $model)
    {
        $model->delete();
        $this->redirect()->back()->with("success","uspesno ste obrisali");
    }

    public function showPull(Request $request, string $exercise)
    {
        //echo $exercise->id . "<br>" . $exercise->name . " " . $exercise->difficulty;
        print_r($exercise);

    }

    public function rnd()
    {
        echo "rnd";
    }
}