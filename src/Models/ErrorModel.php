<?php

namespace Src\Models;

use App\Models\Model;

class ErrorModel extends Model
{

    protected static string $table="errors";
    protected static array $allowed=[
        "status_code","exception_name","title","description"
    ];
    
    


}