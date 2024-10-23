<?php

namespace App\validation;

class OverviewValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return is_string($value) && strlen($value) >= 10 && strlen($value) <= 1024;
    }
}
