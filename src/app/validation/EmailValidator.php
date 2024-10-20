<?php

namespace App\validation;

class EmailValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false && strlen($value) <= 32;
    }
}