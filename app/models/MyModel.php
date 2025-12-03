<?php

namespace App\Models;

class MyModel extends Model
{

    protected static string $table="exercises";
    protected static array $allowed=[
        "name","type","difficulty"
    ];
    
    public function index()
    {
        return "Tabela: " ;
    }


}