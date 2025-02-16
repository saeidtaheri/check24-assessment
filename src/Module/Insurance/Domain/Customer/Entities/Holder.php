<?php

namespace App\Module\Insurance\Domain\Customer\Entities;

use App\Module\Insurance\Application\Validations\Validatable;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class Holder
{
    use Validatable;

    public function __construct(
        #[Assert\NotBlank(message: 'Holder cannot be blank.')]
        #[Assert\Type('string', message: 'Holder  must be String.')]
        public string  $type,

        public ?string $birthDate,
        public ?string $civilStatus,
        public ?string $id,
        public ?string $idType,
        public ?string $licenseDate,
        public ?string $profession,
        public ?string $sex,
    )
    {
        $this->validate();
    }
}