<?php

namespace App\Component\Insurance\Quotation\Reader;

final class ReaderFactory
{
    public function make(Input $type): ReaderInterface
    {
        return match ($type) {
            Input::JSON => new JsonReader,
        };
    }
}