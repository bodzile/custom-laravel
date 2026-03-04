<?php

namespace Src\Migrations;

enum ColumnTypes:string
{
    case STRING      = 'VARCHAR';
    case TEXT        = 'TEXT';
    case INTEGER     = 'INT';
    case BIG_INTEGER = 'BIGINT';
    case SMALL_INT   = 'SMALLINT';
    case BOOLEAN     = 'BOOLEAN';
    case DATE        = 'DATE';
    case DATETIME    = 'DATETIME';
    case TIMESTAMP   = 'TIMESTAMP';
    case FLOAT       = 'FLOAT';
    case DECIMAL     = 'DECIMAL';
    case JSON        = 'JSON';

}
