<?php

namespace App\Tests\Unit\Module\Insurance\Domain\Customer\Entities;

use App\Module\Insurance\Domain\Customer\Entities\Driver;
use PHPUnit\Framework\TestCase;

class DriverTest extends TestCase
{
    public function test_it_should_create_driver_entity_with_valid_data(): void
    {
        $driver = new Driver(
            birthDate: '2002-06-05',
            birthPlace: 'ESP',
            birthPlaceMain: 'ESP',
            children: 'YES',
            civilStatus: 'SOLTERO',
            id: '36714791Y',
            idType: 'dni',
            licenseDate: '2020-12-15',
            licensePlace: 'ESP',
            licensePlaceMain: 'ESP',
            profession: 'Estudiante',
            sex: 'MUJER'
        );

        $this->assertInstanceOf(Driver::class, $driver);
    }

    /**
     * @dataProvider invalidDriverProvider
     */
    public function test_it_should_throw_exception_with_invalid_data(array $invalidData, string $expectedMessage): void
    {
        $this->expectExceptionMessageMatches("/{$expectedMessage}/");

        new Driver(...$invalidData);
    }

    public function invalidDriverProvider(): \Generator
    {
        yield 'Blank BirthDate' => [
            [
                'birthDate' => '',
                'birthPlace' => 'ESP',
                'birthPlaceMain' => 'ESP',
                'children' => 'YES',
                'civilStatus' => 'SOLTERO',
                'id' => '36714791Y',
                'idType' => 'dni',
                'licenseDate' => '2020-12-15',
                'licensePlace' => 'ESP',
                'licensePlaceMain' => 'ESP',
                'profession' => 'Estudiante',
                'sex' => 'MUJER'
            ],
            'Driver birthDate cannot be blank.'
        ];

        yield 'Invalid Children Choice' => [
            [
                'birthDate' => '2002-06-05',
                'birthPlace' => 'ESP',
                'birthPlaceMain' => 'ESP',
                'children' => 'MAYBE',
                'civilStatus' => 'SOLTERO',
                'id' => '36714791Y',
                'idType' => 'dni',
                'licenseDate' => '2020-12-15',
                'licensePlace' => 'ESP',
                'licensePlaceMain' => 'ESP',
                'profession' => 'Estudiante',
                'sex' => 'MUJER'
            ],
            'Driver Children must be either YES or NO.'
        ];

        yield 'Invalid LicenseDate Format' => [
            [
                'birthDate' => '2002-06-05',
                'birthPlace' => 'ESP',
                'birthPlaceMain' => 'ESP',
                'children' => 'YES',
                'civilStatus' => 'SOLTERO',
                'id' => '36714791Y',
                'idType' => 'dni',
                'licenseDate' => 'invalid-date',
                'licensePlace' => 'ESP',
                'licensePlaceMain' => 'ESP',
                'profession' => 'Estudiante',
                'sex' => 'MUJER'
            ],
            'Driver LicenseDate must be valid date.'
        ];
    }
}
