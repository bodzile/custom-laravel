<?php

namespace Src\Models;

use App\Models\Model;

class ErrorModel extends Model
{

    protected static string $table="errors";
    protected static array $allowed=[
        "statusCode","title","description"
    ];
    
    


}