<?php

namespace App\validation\traits;

trait SpecialStringValidationTrait
{
    public function validateStringLength($value, $minLength, $maxLength): bool
    {
        return is_string($value) && mb_strlen($value) >= $minLength && mb_strlen($value) <= $maxLength;
    }
}