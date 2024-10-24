<?php

namespace App\validation\traits;

trait StringValidationTrait
{
    public function validateStringLength($value, $minLength, $maxLength): bool
    {
        return is_string($value) && strlen($value) >= $minLength && strlen($value) <= $maxLength;
    }
}