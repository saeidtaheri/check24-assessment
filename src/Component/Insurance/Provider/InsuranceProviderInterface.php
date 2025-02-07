<?php

namespace App\Component\Insurance\Provider;

use App\Component\Insurance\Quotation\InsuranceRequest;
use App\Component\Insurance\Quotation\Generator\GeneratorInterface;

interface InsuranceProviderInterface
{
    public function submit(InsuranceRequest $data, GeneratorInterface $generator): bool;
}