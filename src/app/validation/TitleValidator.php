<?php

namespace App\validation;

use App\validation\traits\StringValidationTrait;
use App\validation\traits\SpecialStringValidationTrait;

class TitleValidator implements ValidatorInterface
{
    use StringValidationTrait, SpecialStringValidationTrait {
        SpecialStringValidationTrait::validateStringLength insteadof StringValidationTrait;
        StringValidationTrait::validateStringLength as validateAsciiStringLength;
    }

    public function validate($value): bool
    {
        return $this->validateStringLength($value, 3, 255);
    }

    public function validateAsciiTitle($value): bool
    {
        return $this->validateAsciiStringLength($value, 3, 255);
    }
}