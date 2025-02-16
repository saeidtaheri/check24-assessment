<?php

namespace App\Module\Insurance\Domain\Customer\Entities;

use App\Module\Insurance\Application\Validations\Validatable;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CustomerInput
{
    use Validatable;

    public function __construct(
        public Car               $car,
        public Driver            $driver,
        public Holder            $holder,

        #[Assert\NotBlank(message: 'CustomerInput prevInsuranceExists cannot be blank.')]
        #[Assert\NotNull(message: 'CustomerInput prevInsuranceExists cannot be null.')]
        #[Assert\Choice(['SI', 'NO'], message: 'CustomerInput prevInsuranceExists must be either SI or NO.')]
        public string            $prevInsuranceExists,

        #[Assert\NotBlank(message: 'CustomerInput PrevInsuranceYears cannot be blank.')]
        #[Assert\PositiveOrZero(message: 'CustomerInput PrevInsuranceYears must be a positive number or zero.')]
        public int               $prevInsuranceYears,

        #[Assert\Expression(
            expression: 'this.prevInsuranceExists === "SI" ? value != null : true',
            message: 'CustomerInput PrevInsuranceContractDate is required'
        )]
        #[Assert\Date(message: 'CustomerInput prevInsuranceContractDate must be valid date.')]
        public ?string           $prevInsuranceContractDate = null,

        #[Assert\Expression(
            expression: 'this.prevInsuranceExists === "SI" ? value != null : true',
            message: 'CustomerInput PrevInsuranceExpirationDate is required'
        )]
        #[Assert\Expression(
            expression: '(this.prevInsuranceContractDate !== null && this.prevInsuranceContractDate < value) ? true : false',
            message: 'CustomerInput PrevInsuranceExpirationDate must be greater than the PrevInsuranceContractDate.'
        )]
        #[Assert\Date(message: 'CustomerInput prevInsuranceExpirationDate must be valid date.')]
        public ?string           $prevInsuranceExpirationDate = null,
        public ?OccasionalDriver $occasionalDriver = null,
    )
    {
        $this->validate();
    }

    public function hasOccasionalDriver(): bool
    {
        return $this->occasionalDriver->id ?? false;
    }

    public function isHolderMainDriver(): bool
    {
        return $this->holder->type === 'CONDUCTOR_PRINCIPAL';
    }

    public function hasPrevInsurance(): bool
    {
        return $this->prevInsuranceExists === 'SI';
    }

    public function isPrevInsuranceIsValid(): bool
    {
        return $this->hasPrevInsurance()
            && DateTimeImmutable::createFromFormat('Y-m-d', $this->prevInsuranceExpirationDate)
            > new DateTimeImmutable();
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}