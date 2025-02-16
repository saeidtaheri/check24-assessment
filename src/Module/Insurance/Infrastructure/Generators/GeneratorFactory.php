<?php

namespace App\Module\Insurance\Infrastructure\Generators;

use App\Module\Insurance\Application\Interfaces\Generator\GeneratorInterface;
use App\Module\Insurance\Domain\Enums\OutputType;

final class GeneratorFactory
{
    public function make(OutputType $type): GeneratorInterface
    {
        return match ($type) {
            OutputType::XML => new XmlGenerator,
            OutputType::JSON => new JsonGenerator,
        };
    }
}