<?php

namespace App\Tests\Unit\Module\Insurance\Domain\Insurer\Entities;

use App\Module\Insurance\Domain\Enums\AdditionalDriver;
use App\Module\Insurance\Domain\Enums\Driver;
use App\Module\Insurance\Domain\Enums\Holder;
use App\Module\Insurance\Domain\Enums\InsuranceStatus;
use App\Module\Insurance\Domain\Insurer\Entities\DatosConductor;
use PHPUnit\Framework\TestCase;

class DatosConductorTest extends TestCase
{
    public function test_it_should_create_datos_conductor_entity_with_valid_data(): void
    {
        $datosConductor = new DatosConductor(
            Holder::IS_MAIN_DRIVER->value,
            Driver::HAS_MORE_THAN_ONE_DRIVER->value,
            (new \DateTimeImmutable())->format('Y-m-d'),
            2,
            AdditionalDriver::INCLUDED->value,
            InsuranceStatus::VALID->value,
        );

        $this->assertInstanceOf(DatosConductor::class, $datosConductor);
    }

    /**
     * @dataProvider invalidDatosConductorProvider
     */
    public function test_it_should_throw_exception_with_invalid_datos_conductor_data(array $invalidData, string $expectedMessage): void
    {
        $this->expectExceptionMessageMatches("/{$expectedMessage}/");

        new DatosConductor(...$invalidData);
    }

    public function invalidDatosConductorProvider(): \Generator
    {
        yield 'Blank CondPpalEsTomador' => [
            [
                'condPpalEsTomador' => '',
                'conductorUnico' => 'ESP',
                'fecCot' => '2025-02-15',
                'anosSegAnte' => 2,
                'nroCondOca' => 1,
                'seguroEnVigor' => '36714791Y',
            ],
            'CondPpalEsTomador cannot be blank.'
        ];

        yield 'Invalid CondPpalEsTomador value' => [
            [
                'condPpalEsTomador' => 'test',
                'conductorUnico' => 'ESP',
                'fecCot' => 'ESP',
                'anosSegAnte' => 2,
                'nroCondOca' => 1,
                'seguroEnVigor' => '36714791Y',
            ],
            'CondPpalEsTomador must be either YES or NO.'
        ];

        yield 'Blank ConductorUnico value' => [
            [
                'condPpalEsTomador' => 'YES',
                'conductorUnico' => '',
                'fecCot' => 'ESP',
                'anosSegAnte' => 2,
                'nroCondOca' => 1,
                'seguroEnVigor' => '36714791Y',
            ],
            'ConductorUnico cannot be blank.'
        ];

        yield 'Invalid ConductorUnico value' => [
            [
                'condPpalEsTomador' => 'YES',
                'conductorUnico' => 'test',
                'fecCot' => 'ESP',
                'anosSegAnte' => 2,
                'nroCondOca' => 1,
                'seguroEnVigor' => '36714791Y',
            ],
            'ConductorUnico must be either YES or NO.'
        ];

        yield 'Blank FecCot value' => [
            [
                'condPpalEsTomador' => 'YES',
                'conductorUnico' => 'test',
                'fecCot' => '',
                'anosSegAnte' => 2,
                'nroCondOca' => 1,
                'seguroEnVigor' => '36714791Y',
            ],
            'FecCot cannot be blank.'
        ];

        yield 'Invalid FecCot value' => [
            [
                'condPpalEsTomador' => 'YES',
                'conductorUnico' => 'test',
                'fecCot' => 'test',
                'anosSegAnte' => 2,
                'nroCondOca' => 1,
                'seguroEnVigor' => '36714791Y',
            ],
            'FecCot must be valid date.'
        ];

        yield 'Negative AnosSegAnte value' => [
            [
                'condPpalEsTomador' => 'YES',
                'conductorUnico' => 'test',
                'fecCot' => '2025-02-15',
                'anosSegAnte' => -1,
                'nroCondOca' => 1,
                'seguroEnVigor' => '36714791Y',
            ],
            'AnosSegAnte must be a positive number or zero.'
        ];

        yield 'Invalid Negative NroCondOca value' => [
            [
                'condPpalEsTomador' => 'YES',
                'conductorUnico' => 'test',
                'fecCot' => '2025-02-15',
                'anosSegAnte' => 1,
                'nroCondOca' => -1,
                'seguroEnVigor' => '36714791Y',
            ],
            'NroCondOca must be a positive number or zero.'
        ];

        yield 'Blank SeguroEnVigor value' => [
            [
                'condPpalEsTomador' => 'YES',
                'conductorUnico' => 'test',
                'fecCot' => '2025-02-15',
                'anosSegAnte' => 1,
                'nroCondOca' => 2,
                'seguroEnVigor' => '',
            ],
            'SeguroEnVigor cannot be blank.'
        ];

        yield 'Invalid SeguroEnVigor value' => [
            [
                'condPpalEsTomador' => 'YES',
                'conductorUnico' => 'test',
                'fecCot' => '2025-02-15',
                'anosSegAnte' => 1,
                'nroCondOca' => 2,
                'seguroEnVigor' => 'test',
            ],
            'SeguroEnVigor must be either YES or NO.'
        ];
    }
}
