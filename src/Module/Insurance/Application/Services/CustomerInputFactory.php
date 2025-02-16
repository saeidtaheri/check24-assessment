<?php

namespace App\Module\Insurance\Application\Services;

use App\Module\Insurance\Domain\Customer\Entities\Car;
use App\Module\Insurance\Domain\Customer\Entities\CustomerInput;
use App\Module\Insurance\Domain\Customer\Entities\Driver;
use App\Module\Insurance\Domain\Customer\Entities\Holder;
use App\Module\Insurance\Domain\Customer\Entities\OccasionalDriver;

final readonly class CustomerInputFactory
{
    public function createFromArray(array $data): CustomerInput
    {
        $car = $this->makeCar($data);
        $driver = $this->makeDriver($data);
        $occasionalDriver = ($data['occasionalDriver'] === 'SI')
            ? $this->makeOccasionalDriver($data)
            : null;

        $holder = $this->makeHolder($data);

        return $this->createEntity(CustomerInput::class, [
            $car,
            $driver,
            $holder,
            $data['prevInsurance_exists'],
            $data['prevInsurance_years'],
            $data['prevInsurance_contractDate'],
            $data['prevInsurance_expirationDate'],
            $occasionalDriver
        ]);
    }

    /**
     * @param array $data
     * @return Car
     */
    private function makeCar(array $data): Car
    {
        return $this->createEntity(Car::class, [
            $data['car_brand'],
            $data['car_fuel'],
            $data['car_model'],
            $data['car_power'],
            $data['car_purchaseSituation'],
            $data['car_version'],
            $data['car_purchaseDate'] ?? null,
            $data['car_registrationDate'] ?? null,
        ]);
    }

    /**
     * @param array $data
     * @return Driver
     */
    private function makeDriver(array $data): Driver
    {
        return $this->createEntity(Driver::class, [
            $data['driver_birthDate'],
            $data['driver_birthPlace'],
            $data['driver_birthPlaceMain'],
            $data['driver_children'],
            $data['driver_civilStatus'],
            $data['driver_id'],
            $data['driver_idType'],
            $data['driver_licenseDate'],
            $data['driver_licensePlace'],
            $data['driver_licensePlaceMain'],
            $data['driver_profession'],
            $data['driver_sex']
        ]);
    }

    /**
     * @param array $data
     * @return OccasionalDriver
     */
    private function makeOccasionalDriver(array $data): OccasionalDriver
    {
        return $this->createEntity(OccasionalDriver::class, [
            $data['occasionalDriver_birthDate'],
            $data['occasionalDriver_civilStatus'],
            $data['occasionalDriver_id'],
            $data['occasionalDriver_idType'],
            $data['occasionalDriver_licenseDate'],
            $data['occasionalDriver_profession'],
            $data['occasionalDriver_sex'],
            $data['occasionalDriver_youngest']
        ]);
    }

    /**
     * @param array $data
     * @return Holder
     */
    private function makeHolder(array $data): Holder
    {
        return $this->createEntity(Holder::class, [
            $data['holder'],
            $data['holder_birthDate'],
            $data['holder_civilStatus'],
            $data['holder_id'],
            $data['holder_idType'],
            $data['holder_licenseDate'],
            $data['holder_profession'],
            $data['holder_sex'],
        ]);
    }

    private function createEntity(string $class, array $data)
    {
        return new $class(...$data);
    }
}