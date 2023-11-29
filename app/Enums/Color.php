<?php

declare(strict_types=1);

namespace App\Enums;

use function array_column;

enum Color: string
{
    case BerryRed = 'berry_red';
    case Red = 'red';
    case Green = 'green';


    public static function select(): array
    {
        return array_column(
            array: self::cases(),
            column_key: 'value',
        );
    }
}
