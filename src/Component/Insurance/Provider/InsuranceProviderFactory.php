<?php

namespace App\Component\Insurance\Provider;

use App\Component\Insurance\Provider\Acme\AcmeInsuranceProvider;

final readonly class InsuranceProviderFactory
{
    public function make(InsuranceProvider $insuranceProvider): InsuranceProviderInterface
    {
        return match ($insuranceProvider) {
            InsuranceProvider::ACME => new AcmeInsuranceProvider,
        };
    }
}