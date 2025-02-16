<?php

namespace App\Module\Insurance\Domain\Enums;

enum Driver: string
{
    case HAS_MORE_THAN_ONE_DRIVER = 'YES';
    case HAS_ONE_DRIVER = 'NO';
}
