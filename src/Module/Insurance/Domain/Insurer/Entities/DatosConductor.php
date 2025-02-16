<?php

namespace App\Module\Insurance\Domain\Insurer\Entities;

use App\Module\Insurance\Application\Validations\Validatable;
use Symfony\Component\Validator\Constraints as Assert;

class DatosConductor
{
    use Validatable;
    public function __construct(
        #[Assert\NotBlank(message: 'CondPpalEsTomador cannot be blank.')]
        #[Assert\NotNull(message: 'CondPpalEsTomador cannot be null.')]
        #[Assert\Choice(['YES', 'NO'], message: 'CondPpalEsTomador must be either YES or NO.')]
        public string $condPpalEsTomador,

        #[Assert\NotBlank(message: 'ConductorUnico cannot be blank.')]
        #[Assert\Choice(['YES', 'NO'], message: 'ConductorUnico must be either YES or NO.')]
        public string $conductorUnico,

        #[Assert\NotBlank(message: 'FecCot cannot be blank.')]
        #[Assert\Date( message: 'FecCot must be valid date.')]
        public string $fecCot,

        #[Assert\NotNull(message: 'AnosSegAnte cannot be null.')]
        #[Assert\Type('integer', message: 'AnosSegAnte must be an integer.')]
        #[Assert\PositiveOrZero(message: 'AnosSegAnte must be a positive number or zero.')]
        public int    $anosSegAnte,

        #[Assert\NotBlank(message: 'NroCondOca cannot be blank.')]
        #[Assert\Type('integer', message: 'NroCondOca must be an integer.')]
        #[Assert\PositiveOrZero(message: 'NroCondOca must be a positive number or zero.')]
        public int    $nroCondOca,

        #[Assert\NotBlank(message: 'SeguroEnVigor cannot be blank.')]
        #[Assert\Choice(['YES', 'NO'], message: 'SeguroEnVigor must be either YES or NO.')]
        public string $seguroEnVigor
    )
    {
        $this->validate();
    }

    public static function CreateFromArray(array $data): self
    {
        return new self(
            condPpalEsTomador: $data['condPpalEsTomador'],
            conductorUnico: $data['conductorUnico'],
            fecCot: $data['fecCot'],
            anosSegAnte: $data['anosSegAnte'],
            nroCondOca: $data['nroCondOca'],
            seguroEnVigor: $data['seguroEnVigor'],
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}