<?php

namespace App\validation\traits;

trait NumericValidationTrait
{
    public function validateNumericRange($value, $min, $max): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        $value = (float)$value;
        return $value >= $min && $value <= $max;
    }
}
