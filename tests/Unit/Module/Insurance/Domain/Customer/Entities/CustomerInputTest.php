<?php

namespace App\Tests\Unit\Module\Insurance\Domain\Customer\Entities;

use App\Module\Insurance\Domain\Customer\Entities\Car;
use App\Module\Insurance\Domain\Customer\Entities\CustomerInput;
use App\Module\Insurance\Domain\Customer\Entities\Driver;
use App\Module\Insurance\Domain\Customer\Entities\Holder;
use App\Module\Insurance\Domain\Customer\Entities\OccasionalDriver;
use PHPUnit\Framework\TestCase;

class CustomerInputTest extends TestCase
{
    private Car $car;
    private Driver $driver;
    private Holder $holder;
    private OccasionalDriver $occasionalDriver;

    protected function setUp(): void
    {
        $this->car = new Car(
            'SEAT',
            'Gasoline',
            'IBIZA',
            '120 HP',
            'NEW',
            '00540140903',
            '2022-01-01',
            '2022-06-05'
        );

        $this->driver = new Driver(
            '2002-06-05',
            'ESP',
            'ESP',
            'YES',
            'SOLTERO',
            '36714791Y',
            'dni',
            '2020-12-15',
            'ESP',
            'ESP',
            'Estudiante',
            'MUJER'
        );

        $this->holder = new Holder(
            'CONDUCTOR_PRINCIPAL',
            '1985-06-15',
            'CASADO',
            '98765432Y',
            'DNI',
            '2005-07-20',
            'Engineer',
            'HOMBRE',
        );

        $this->occasionalDriver = new OccasionalDriver(
            '1985-06-15',
            'CASADO',
            '98765432Y',
            'DNI',
            '2002-06-15',
            'Engineer',
            'HOMBRE',
            'youngest'
        );
    }

    public function test_customer_input_entity_should_create_with_optional_valid_data(): void
    {
        $customerInput = new CustomerInput(
            $this->car,
            $this->driver,
            $this->holder,
            'SI',
            2,
            '2005-07-20',
            '2007-07-25',
            $this->occasionalDriver,
        );

        $this->assertTrue($customerInput->hasPrevInsurance());
        $this->assertTrue($customerInput->isHolderMainDriver());
        $this->assertTrue($customerInput->hasOccasionalDriver());
        $this->assertInstanceOf(CustomerInput::class, $customerInput);
    }

    /**
     * @dataProvider invalidCustomerInputProvider
     */
    public function test_it_should_throw_exception_with_invalid_data(array $invalidData, string $expectedMessage): void
    {
        $this->expectExceptionMessageMatches("/{$expectedMessage}/");
        new CustomerInput(...$invalidData);
    }

    public function invalidCustomerInputProvider(): \Generator
    {
        $this->setUp();

        yield 'Invalid prevInsuranceExist value' => [
            [
                $this->car,
                $this->driver,
                $this->holder,
                'test',
                2,
                '2005-07-20',
                '2005-07-01',
            ],
            'CustomerInput prevInsuranceExists must be either SI or NO.'
        ];

        yield 'Invalid prevInsuranceYears value' => [
            [
                $this->car,
                $this->driver,
                $this->holder,
                'SI',
                -1,
                '2005-07-20',
                '2005-07-01',
            ],
            'CustomerInput PrevInsuranceYears must be a positive number or zero.'
        ];

        yield 'Invalid prevInsuranceContractDate value' => [
            [
                $this->car,
                $this->driver,
                $this->holder,
                'SI',
                2,
                't',
                '2005-07-01',
            ],
            'CustomerInput prevInsuranceContractDate must be valid date.'
        ];

        yield 'Invalid prevInsuranceExpirationDate value' => [
            [
                $this->car,
                $this->driver,
                $this->holder,
                'SI',
                2,
                '2005-07-01',
                't',
            ],
            'CustomerInput prevInsuranceExpirationDate must be valid date.'
        ];

        yield 'Invalid prev Insurance Expiration Date' => [
            [
                $this->car,
                $this->driver,
                $this->holder,
                'SI',
                2,
                '2005-07-20',
                '2002-07-01',
            ],
            'CustomerInput PrevInsuranceExpirationDate must be greater than the PrevInsuranceContractDate.'
        ];
    }
}
