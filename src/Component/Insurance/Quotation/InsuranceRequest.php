<?php

namespace App\Component\Insurance\Quotation;

use App\Component\Insurance\Quotation\Exception\ValidationException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

final readonly class InsuranceRequest
{
    public function __construct(
        #[Assert\NotBlank(message: 'CondPpalEsTomador cannot be blank.')]
        #[Assert\NotNull(message: 'CondPpalEsTomador cannot be null.')]
        #[Assert\Choice(['YES', 'NO'], message: 'CondPpalEsTomador must be either YES or NO.')]
        public string $condPpalEsTomador,
        #[Assert\NotBlank(message: 'ConductorUnico cannot be blank.')]
        #[Assert\Choice(['YES', 'NO'], message: 'ConductorUnico must be either YES or NO.')]
        public string $conductorUnico,
        #[Assert\NotBlank(message: 'AnosSegAnte cannot be blank.')]
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

    public static function fromArray(array $data): self
    {
        return new self(
            condPpalEsTomador: $data['CondPpalEsTomador'],
            conductorUnico: $data['ConductorUnico'],
            anosSegAnte: $data['AnosSegAnte'],
            nroCondOca: $data['NroCondOca'],
            seguroEnVigor: $data['SeguroEnVigor']
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * @throws ValidationException
     */
    private function validate(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $errors = $validator->validate($this);
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}