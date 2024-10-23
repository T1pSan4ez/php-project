<?php

namespace App\validation;

class OriginalLanguageValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return is_string($value) && strlen($value) === 2;
    }
}