<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Models\MyModel;

class MyController extends Controller
{
    public function index(Request $request)
    {

        $users=MyModel::find(1);

        return $this->view("test",compact("users"));
    }

    public function index2()
    {
        $name="pera";

        return $this->view("welcome",compact("name"));
    }

    public function addUser(Request $request)
    {
        $request->validate([
            "email" => "required|alpha",
            "password" => "required|numeric|min:5"
        ]);

        $this->redirect()->back()->with("success","uspesno ste poslali");
    }

    public function delete(Request $request,$id)
    {
        die($id);
    }
}