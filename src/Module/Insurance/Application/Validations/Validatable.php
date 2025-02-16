<?php

namespace App\Module\Insurance\Application\Validations;

use Symfony\Component\Validator\Validation;
use App\Module\Insurance\Application\Exceptions\ValidationException;

trait Validatable
{
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