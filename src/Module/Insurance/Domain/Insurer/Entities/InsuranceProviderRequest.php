<?php

namespace App\Module\Insurance\Domain\Insurer\Entities;

final readonly class InsuranceProviderRequest
{
    public function __construct(
         public DatosConductor $datosConductor,
    )
    {}

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}