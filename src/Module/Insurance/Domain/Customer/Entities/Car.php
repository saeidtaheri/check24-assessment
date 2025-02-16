<?php

namespace App\Module\Insurance\Domain\Customer\Entities;

use App\Module\Insurance\Application\Validations\Validatable;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class Car
{
    use Validatable;

    public function __construct(
        #[Assert\NotBlank(message: 'Car Brand cannot be blank.')]
        public string  $brand,

        #[Assert\NotBlank(message: 'Car Fuel cannot be blank.')]
        public string  $fuel,

        #[Assert\NotBlank(message: 'Car Model cannot be blank.')]
        public string  $model,

        #[Assert\NotBlank(message: 'Car Power cannot be blank.')]
        public string  $power,

        #[Assert\NotBlank(message: 'Car Purchase Situation cannot be blank.')]
        public string  $purchaseSituation,

        #[Assert\NotBlank(message: 'Car Version cannot be blank.')]
        public string  $version,

        public ?string $purchaseDate,
        public ?string $registrationDate,
    )
    {
        $this->validate();
    }

    public static function createFromArray(array $data): self
    {
//        if (!is_string($data['brand'])) {
//            throw new \InvalidArgumentException('Car Brand must be string.');
//        }

        return new self(
            $data['brand'],
            $data['fuel'],
            $data['model'],
            $data['power'],
            $data['purchaseSituation'],
            $data['version'],
            $data['purchaseDate'],
            $data['registrationDate'],
        );
    }
}