<?php

namespace App\Component\Insurance\Quotation\Reader;

interface ReaderInterface
{
    public function readFromFile(string $filePath): array;
}