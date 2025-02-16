<?php

namespace App\Tests\Unit\Module\Insurance\Infrastructure\Reader;

use App\Module\Insurance\Application\Exceptions\InvalidFileException;
use App\Module\Insurance\Infrastructure\Readers\JsonReader;
use PHPUnit\Framework\TestCase;

class JsonReaderTest extends TestCase
{
    private JsonReader $jsonReader;

    protected function setUp(): void
    {
        $this->jsonReader = new JsonReader();
    }

    public function test_it_can_read_and_parse_data_from_file()
    {
        $filePath = 'tests/Unit/Module/Insurance/Infrastructure/Reader/artifacts/valid.json';
        $data = $this->jsonReader->readFromFile($filePath);

        $this->assertIsArray($data);
        $this->assertSame(['car_brand' => 'SEAT',  "car_fuel" => "Gasolina"], $data);
    }

    /**
     * @dataProvider DataProvider
     */
    public function test_it_should_throw_exception_with_invalid_json_file(string $filePath, string $errorMessage)
    {
        $this->expectException(InvalidFileException::class);
        $this->expectExceptionMessage($errorMessage);

        $this->jsonReader->readFromFile($filePath);
    }

    public function DataProvider(): \Generator
    {
        yield 'invalid json file' => [
            'filePath' =>  'tests/Unit/Module/Insurance/Infrastructure/Reader/artifacts/invalid.json',
            'message' => 'Can not read the file'
        ];

        yield 'missing file' => [
            'filePath' =>  'tests/Unit/Module/Insurance/Presentation/Command/artifacts/missing-file.json',
            'message' => 'File not found'
        ];
    }
}