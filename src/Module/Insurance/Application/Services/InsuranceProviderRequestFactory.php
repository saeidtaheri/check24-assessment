<?php

namespace App\Module\Insurance\Application\Services;

use App\Module\Insurance\Domain\Customer\Entities\CustomerInput;
use App\Module\Insurance\Domain\Enums\AdditionalDriver;
use App\Module\Insurance\Domain\Enums\Driver;
use App\Module\Insurance\Domain\Enums\Holder;
use App\Module\Insurance\Domain\Enums\InsuranceStatus;
use App\Module\Insurance\Domain\Insurer\Entities\DatosConductor;
use App\Module\Insurance\Domain\Insurer\Entities\InsuranceProviderRequest;

final readonly class InsuranceProviderRequestFactory
{
    public function createFromCustomerInput(CustomerInput $customerInput): InsuranceProviderRequest
    {
        $datosConductor = $this->makeDatosConductor($customerInput);

        return $this->createEntity(InsuranceProviderRequest::class, [
            $datosConductor,
        ]);
    }

    /**
     * @param CustomerInput $customerInput
     * @return DatosConductor
     */
    private function makeDatosConductor(CustomerInput $customerInput): DatosConductor
    {
        return $this->createEntity(DatosConductor::class, [
            'condPpalEsTomador' => $customerInput->isHolderMainDriver()
                ? Holder::IS_MAIN_DRIVER->value
                : Holder::IS_NOT_MAIN_DRIVER->value,
            'conductorUnico' => $customerInput->hasOccasionalDriver()
                ? Driver::HAS_MORE_THAN_ONE_DRIVER->value
                : Driver::HAS_ONE_DRIVER->value,
            'fecCot' => (new \DateTimeImmutable())->format('Y-m-d'),
            'anosSegAnte' => $customerInput->prevInsuranceYears,
            'nroCondOca' => $customerInput->hasOccasionalDriver()
                ? AdditionalDriver::INCLUDED->value
                : AdditionalDriver::NOT_INCLUDED->value,
            'seguroEnVigor' => $customerInput->isPrevInsuranceIsValid()
                ? InsuranceStatus::VALID->value
                : InsuranceStatus::EXPIRED->value,
        ]);
    }

    private function createEntity(string $class, array $data)
    {
        return new $class(...$data);
    }
}