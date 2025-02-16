<?php

namespace App\Module\Insurance\Domain\Enums;

enum AdditionalDriver: int
{
    case INCLUDED = 1;
    case NOT_INCLUDED = 0;
}
