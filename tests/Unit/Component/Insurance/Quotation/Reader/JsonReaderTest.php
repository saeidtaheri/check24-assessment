<?php

namespace App\Tests\Unit\Component\Insurance\Quotation\Reader;

use App\Component\Insurance\Quotation\Exception\InvalidFileException;
use App\Component\Insurance\Quotation\Reader\JsonReader;
use PHPUnit\Framework\TestCase;

class JsonReaderTest extends TestCase
{
    private JsonReader $jsonReader;

    protected function setUp(): void
    {
        $this->jsonReader = new JsonReader();
    }

    public function test_read_from_file_throws_Exception_when_file_not_found()
    {
        $filePath = __DIR__ . '/non_existent_file.json';

        $this->expectException(InvalidFileException::class);
        $this->expectExceptionMessage("File {$filePath} not found");

        $this->jsonReader->readFromFile($filePath);
    }

    public function test_read_from_file_throws_exception_for_invalid_json()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Can not read the file:');

        try {
            $filePath = __DIR__ . '/invalid.json';
            file_put_contents($filePath, 'invalid json');
            $this->jsonReader->readFromFile($filePath);
        } finally {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $this->assertFileDoesNotExist($filePath);
    }

    public function test_it_can_read_and_parse_data_from_file()
    {
        $filePath = __DIR__ . '/test.json';
        file_put_contents($filePath, '{"SeguroEnVigor": "YES"}');
        $data = $this->jsonReader->readFromFile($filePath);

        $this->assertIsArray($data);
        $this->assertSame(['SeguroEnVigor' => 'YES'], $data);

        unlink($filePath);
    }
}