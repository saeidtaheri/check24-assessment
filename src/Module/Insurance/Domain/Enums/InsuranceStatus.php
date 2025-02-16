<?php

namespace App\Module\Insurance\Domain\Enums;

enum InsuranceStatus: string
{
    case VALID = 'YES';
    case EXPIRED = 'NO';
}
