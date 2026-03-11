<?php

namespace Src\Migrations\Enums;

enum KeyType:string
{
    case PRIMARY = 'primary';
    case FOREIGN = 'foreign';
}
