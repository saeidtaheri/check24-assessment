<?php

namespace App\Module\Insurance\Application\Exceptions;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationException extends RuntimeException
{
    public function __construct(public ConstraintViolationListInterface $violations)
    {
        parent::__construct($violations);
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}