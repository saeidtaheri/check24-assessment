<?php

namespace App\Module\Insurance\Application\Interfaces\Reader;

interface ReaderInterface
{
    public function readFromFile(string $filePath): array;
}