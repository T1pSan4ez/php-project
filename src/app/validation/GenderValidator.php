<?php

namespace App\validation;

class GenderValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return in_array($value, ['male', 'female', 'another'], true);
    }
}
