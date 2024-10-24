<?php

namespace App\validation;

use App\validation\traits\NumericValidationTrait;

class VoteAverageValidator implements ValidatorInterface
{
    use NumericValidationTrait;

    public function validate($value): bool
    {
        return $this->validateNumericRange($value, 0, 10);
    }
}