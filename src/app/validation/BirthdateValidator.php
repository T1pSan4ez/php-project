<?php

namespace App\validation;

class BirthdateValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        if (empty($value)) {
            return true;
        }

        $date = \DateTime::createFromFormat('Y-m-d', $value);
        return $date && $date->format('Y-m-d') === $value;
    }
}
