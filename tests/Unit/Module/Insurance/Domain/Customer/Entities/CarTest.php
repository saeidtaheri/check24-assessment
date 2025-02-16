<?php

namespace App\Tests\Unit\Module\Insurance\Domain\Customer\Entities;

use App\Module\Insurance\Domain\Customer\Entities\Car;
use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    public function test_car_entity_should_create_with_valid_data(): void
    {
        $car = new Car(
            brand: 'SEAT',
            fuel: 'Gasoline',
            model: 'IBIZA',
            power: '120 HP',
            purchaseSituation: 'NEW',
            version: '00540140903',
            purchaseDate: '2022-01-01',
            registrationDate: '2022-06-05'
        );

        $this->assertInstanceOf(Car::class, $car);
    }

    /**
     * @dataProvider invalidCarProvider
     */
    public function test_it_should_throw_exception_with_invalid_data($data, $expectedMessage): void
    {
        $this->expectExceptionMessageMatches("/{$expectedMessage}/");

        new Car(...$data);
    }

    public function invalidCarProvider(): \Generator
    {
        yield 'Blank Brand' => [
            [
                'brand' => '',
                'fuel' => 'Gasoline',
                'model' => 'IBIZA',
                'power' => '120 HP',
                'purchaseSituation' => 'NEW',
                'version' => '00540140903',
                'purchaseDate' => '2022-01-01',
                'registrationDate' => '2022-06-05'
            ],
            'Car Brand cannot be blank.'
        ];

        yield 'Null Model' => [
            [
                'brand' => 'SEAT',
                'fuel' => 'Gasoline',
                'model' => null,
                'power' => '120 HP',
                'purchaseSituation' => 'NEW',
                'version' => '00540140903',
                'purchaseDate' => '2022-01-01',
                'registrationDate' => '2022-06-05'
            ],
            'must be of type string, null given'
        ];
    }
}
