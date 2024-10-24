<?php

namespace App\validation;

use App\validation\traits\NumericValidationTrait;

class VoteCountValidator implements ValidatorInterface
{
    use NumericValidationTrait;

    public function validate($value): bool
    {
        return $this->validateNumericRange($value, 0, PHP_INT_MAX);
    }
}