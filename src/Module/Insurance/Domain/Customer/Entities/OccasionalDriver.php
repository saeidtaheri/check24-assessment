<?php

namespace App\Module\Insurance\Domain\Customer\Entities;

use App\Module\Insurance\Application\Validations\Validatable;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class OccasionalDriver
{
    use Validatable;

    public function __construct(
        #[Assert\NotBlank(message: 'OccasionalDriver BirthDate cannot be blank.')]
        #[Assert\Date(message: 'OccasionalDriver BirthDate must be valid date.')]
        public string $birthDate,

        #[Assert\NotBlank(message: 'OccasionalDriver CivilStatus cannot be blank.')]
        #[Assert\Type('string', message: 'OccasionalDriver CivilStatus must be String.')]
        public string $civilStatus,

        #[Assert\NotBlank(message: 'OccasionalDriver Id cannot be blank.')]
        #[Assert\Type('string', message: 'OccasionalDriver Id must be String.')]
        public string $id,

        #[Assert\NotBlank(message: 'OccasionalDriver Id Type cannot be blank.')]
        #[Assert\Type('string', message: 'OccasionalDriver Id Type must be String.')]
        public string $idType,

        #[Assert\NotBlank(message: 'OccasionalDriver LicenseDate cannot be blank.')]
        #[Assert\Date( message: 'OccasionalDriver LicenseDate must be valid date.')]
        public string $licenseDate,

        #[Assert\NotBlank(message: 'OccasionalDriver Profession cannot be blank.')]
        #[Assert\Type('string', message: 'OccasionalDriver Profession must be String.')]
        public string $profession,

        #[Assert\NotBlank(message: 'OccasionalDriver Sex cannot be blank.')]
        #[Assert\Type('string', message: 'OccasionalDriver Sex must be String.')]
        public string $sex,

        #[Assert\NotBlank(message: 'OccasionalDriver Youngest cannot be blank.')]
        #[Assert\Type('string', message: 'OccasionalDriver Youngest must be String.')]
        public string $youngest,
    )
    {
        $this->validate();
    }
}