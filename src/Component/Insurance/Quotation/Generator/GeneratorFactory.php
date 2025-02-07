<?php

namespace App\Component\Insurance\Quotation\Generator;

final class GeneratorFactory
{
    public function make(Output $type): GeneratorInterface
    {
        return match ($type) {
            Output::XML => new XmlGenerator,
            Output::JSON => new JsonGenerator,
        };
    }
}