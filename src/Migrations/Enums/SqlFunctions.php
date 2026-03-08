<?php

namespace Src\Migrations\Enums;

enum SqlFunctions:string
{
    // Datum i Vreme
    case Now = 'NOW()';
    case CurrentTimestamp = 'CURRENT_TIMESTAMP';
    case CurrentDate = 'CURRENT_DATE';

    // Identifikacija
    case CurrentUser = 'CURRENT_USER';
    case Database = 'DATABASE()';
    case Uuid = 'UUID()'; // Specifično za MySQL/Postgres

    // String operacije (obično se koriste u SELECT-u)
    case Upper = 'UPPER';
    case Lower = 'LOWER';
    case Length = 'LENGTH';
}
