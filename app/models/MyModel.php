<?php

namespace App\Models;

class MyModel extends Model
{

    protected static string $table="exercises";
    public function index()
    {
        return "Tabela: " ;
    }


}