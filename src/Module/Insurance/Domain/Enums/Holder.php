<?php

namespace App\Module\Insurance\Domain\Enums;

enum Holder: string
{
    case IS_MAIN_DRIVER = 'YES';
    case IS_NOT_MAIN_DRIVER = 'NO';
}
