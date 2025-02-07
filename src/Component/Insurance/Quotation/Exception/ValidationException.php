<?php

namespace App\Component\Insurance\Quotation\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationException extends RuntimeException
{
    public function __construct(public ConstraintViolationListInterface $violations)
    {
        parent::__construct('Validation failed.');
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}