<?php

namespace App\Module\Insurance\Infrastructure\Readers;

use App\Module\Insurance\Application\Exceptions\InvalidFileException;
use App\Module\Insurance\Application\Interfaces\Reader\ReaderInterface;

final class JsonReader implements ReaderInterface
{
    public function readFromFile(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new InvalidFileException("File not found");
        }

        $result = json_decode(file_get_contents($filePath), true);

        if (is_null($result)) {
            throw new InvalidFileException("Can not read the file");
        }

        return $result;
    }
}