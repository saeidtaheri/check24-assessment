<?php

namespace App\Tests\Unit\Module\Insurance\Domain\Customer\Entities;

use App\Module\Insurance\Application\Exceptions\ValidationException;
use App\Module\Insurance\Domain\Customer\Entities\OccasionalDriver;
use PHPUnit\Framework\TestCase;

final class OccasionalDriverTest extends TestCase
{
    public function test_it_should_create_occasional_driver_entity_with_valid_data(): void
    {
        $occasionalDriver = new OccasionalDriver(...[
            'birthDate' => '1995-04-10',
            'civilStatus' => 'SOLTERO',
            'id' => '12345678X',
            'idType' => 'DNI',
            'licenseDate' => '2013-05-15',
            'profession' => 'Engineer',
            'sex' => 'HOMBRE',
            'youngest' => 'HIJO',
        ]);

        $this->assertInstanceOf(OccasionalDriver::class, $occasionalDriver);
    }

    /**
     * @dataProvider invalidOccasionalDriverProvider
     */
    public function test_throws_exception_with_invalid_data(array $invalidData, string $expectedMessage): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessageMatches("/{$expectedMessage}/");

        new OccasionalDriver(...$invalidData);
    }

    public function invalidOccasionalDriverProvider(): \Generator
    {
        yield 'Blank BirthDate' => [
            [
                'birthDate' => '' ,
                'civilStatus' => 'SOLTERO',
                'id' => '12345678X',
                'idType' => 'DNI',
                'licenseDate' => '1995-04-10',
                'profession' => 'Engineer',
                'sex' => 'HOMBRE',
                'youngest' => 'Test',
            ],
            'OccasionalDriver BirthDate cannot be blank.'
        ];

        yield 'Invalid BirthDate' => [
            [
                'birthDate' => 'invalid-date' ,
                'civilStatus' => 'SOLTERO',
                'id' => '12345678X',
                'idType' => 'DNI',
                'licenseDate' => '1995-04-10',
                'profession' => 'Engineer',
                'sex' => 'HOMBRE',
                'youngest' => 'Test',
            ],
            'OccasionalDriver BirthDate must be valid date.'
        ];

        yield 'Blank CivilStatus' => [
            [
                'birthDate' => '1995-04-10' ,
                'civilStatus' => '',
                'id' => '12345678X',
                'idType' => 'DNI',
                'licenseDate' => '1995-04-10',
                'profession' => 'Engineer',
                'sex' => 'HOMBRE',
                'youngest' => 'Test',
            ],
            'OccasionalDriver CivilStatus cannot be blank.'
        ];

        yield 'Invalid LicenseDate' => [
            [
                'birthDate' => '1995-04-10' ,
                'civilStatus' => 'SOLTERO',
                'id' => '12345678X',
                'idType' => 'DNI',
                'licenseDate' => 'invalid-date',
                'profession' => 'Engineer',
                'sex' => 'HOMBRE',
                'youngest' => 'Test',
            ],
            'OccasionalDriver LicenseDate must be valid date.'
        ];

        yield 'Blank LicenseDate' => [
            [
                'birthDate' => '1995-04-10' ,
                'civilStatus' => 'SOLTERO',
                'id' => '12345678X',
                'idType' => 'DNI',
                'licenseDate' => '',
                'profession' => 'Engineer',
                'sex' => 'HOMBRE',
                'youngest' => 'Test',
            ],
            'OccasionalDriver LicenseDate cannot be blank.'
        ];

        yield 'Blank youngest' => [
            [
                'birthDate' => '1995-04-10' ,
                'civilStatus' => 'SOLTERO',
                'id' => '12345678X',
                'idType' => 'DNI',
                'licenseDate' => '2013-05-15',
                'profession' => 'Engineer',
                'sex' => 'HOMBRE',
                'youngest' => '',
            ],
            'Driver Youngest cannot be blank.'
        ];
    }
}
