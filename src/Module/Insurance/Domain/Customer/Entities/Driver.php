<?php

namespace App\Module\Insurance\Domain\Customer\Entities;

use App\Module\Insurance\Application\Validations\Validatable;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class Driver
{
    use Validatable;

    public function __construct(
        #[Assert\NotBlank(message: 'Driver birthDate cannot be blank.')]
        #[Assert\Date(message: 'Driver BirthDate must be valid date.')]
        public string $birthDate,

        #[Assert\NotBlank(message: 'Driver birthPlace cannot be blank.')]
        #[Assert\Type('string', message: 'Driver BirthPlace must be valid date.')]
        public string $birthPlace,

        #[Assert\NotBlank(message: 'Driver BirthPlaceMain cannot be blank.')]
        #[Assert\Type('string', message: 'Driver BirthPlaceMain must be string.')]
        public string $birthPlaceMain,

        #[Assert\NotBlank(message: 'Driver Children cannot be blank.')]
        #[Assert\Choice(['YES', 'NO'], message: 'Driver Children must be either YES or NO.')]
        public string $children,

        #[Assert\NotBlank(message: 'Driver CivilStatus cannot be blank.')]
        #[Assert\Type('string', message: 'Driver CivilStatus must be String.')]
        public string $civilStatus,

        #[Assert\NotBlank(message: 'Driver Id cannot be blank.')]
        #[Assert\Type('string', message: 'Driver Id must be String.')]
        public string $id,

        #[Assert\NotBlank(message: 'Driver Id Type cannot be blank.')]
        #[Assert\Type('string', message: 'Driver Id Type must be String.')]
        public string $idType,

        #[Assert\NotBlank(message: 'Driver LicenseDate cannot be blank.')]
        #[Assert\Date(message: 'Driver LicenseDate must be valid date.')]
        public string $licenseDate,

        #[Assert\NotBlank(message: 'Driver LicensePlace  cannot be blank.')]
        #[Assert\Type('string', message: 'Driver LicensePlace  must be String.')]
        public string $licensePlace,

        #[Assert\NotBlank(message: 'Driver LicensePlaceMain cannot be blank.')]
        #[Assert\Type('string', message: 'Driver LicensePlaceMain must be String.')]
        public string $licensePlaceMain,

        #[Assert\NotBlank(message: 'Driver Profession cannot be blank.')]
        #[Assert\Type('string', message: 'Driver Profession must be String.')]
        public string $profession,

        #[Assert\NotBlank(message: 'Driver Sex cannot be blank.')]
        #[Assert\Type('string', message: 'Driver Sex must be String.')]
        public string $sex
    )
    {
        $this->validate();
    }
}