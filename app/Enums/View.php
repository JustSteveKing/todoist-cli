<?php

declare(strict_types=1);

namespace App\Enums;

enum View: string
{
    case List = 'list';
    case Board = 'board';
}
