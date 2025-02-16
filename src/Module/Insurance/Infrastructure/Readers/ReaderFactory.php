<?php

namespace App\Module\Insurance\Infrastructure\Readers;

use App\Module\Insurance\Application\Interfaces\Reader\ReaderInterface;
use App\Module\Insurance\Domain\Enums\InputType;

final class ReaderFactory
{
    public function make(InputType $type): ReaderInterface
    {
        return match ($type) {
            InputType::JSON => new JsonReader,
        };
    }
}