<?php

namespace App\validation;

class PreferredRatingValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        if (empty($value)) {
            return true;
        }

        return is_numeric($value) && $value >= 1.0 && $value <= 10.0;
    }
}
