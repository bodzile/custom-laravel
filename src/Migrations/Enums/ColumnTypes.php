<?php

namespace Src\Migrations\Enums;

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

    public function getDefaultLength():int
    {
        return match($this)
        {
            self::STRING => 255,

        };
    }

    public function getMaxLength(): string|int
    {
        return match($this) {
            // String tipovi (karakteri/bajtovi)
            self::STRING      => 255,      // Standardni VARCHAR, može do 65535
            self::TEXT        => 65535,    // Standardni TEXT blok
            self::JSON        => 4294967295, // Maksimalna veličina JSON objekta (4GB)

            // Numerički tipovi (Maksimalne vrednosti za SIGNED)
            self::SMALL_INT   => 32767,
            self::INTEGER     => 2147483647,
            self::BIG_INTEGER => '9223372036854775807', // String zbog 64-bit limita
            self::BOOLEAN     => 1,

            // Precizni brojevi (Maksimalni broj cifara)
            self::DECIMAL     => 65,
            self::FLOAT       => 38, // Približan broj eksponenta

            // Vremenski tipovi (Maksimalne vrednosti kao string)
            self::DATE        => '9999-12-31',
            self::DATETIME    => '9999-12-31 23:59:59',
            self::TIMESTAMP   => '2038-01-19 03:14:07',
        };
    }

}
