<?php

namespace App\Component\Insurance\Provider\Acme;

use App\Component\Insurance\Provider\InsuranceProviderInterface;
use App\Component\Insurance\Quotation\InsuranceRequest;
use App\Component\Insurance\Quotation\Generator\GeneratorInterface;

final readonly class AcmeInsuranceProvider implements InsuranceProviderInterface
{
    public function submit(InsuranceRequest $data, GeneratorInterface $generator): bool
    {
        var_dump($generator->generate($data));
        var_dump("curl -X POST https://acmce.com/quote");
        return true;
    }
}