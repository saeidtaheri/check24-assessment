<?php

namespace App\Component\Insurance\Quotation\Reader;

use App\Component\Insurance\Quotation\Exception\InvalidFileException;

final class JsonReader implements ReaderInterface
{
    public function readFromFile(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new InvalidFileException("File {$filePath} not found");
        }

        try {
            return json_decode(
                file_get_contents($filePath),
                true
            );
        } catch (\Throwable $exception) {
            throw new \Exception("Can not read the file: {$exception->getMessage()}");
        }
    }
}