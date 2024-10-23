<?php

namespace App\validation;

class PopularityValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return is_numeric($value) && $value >= 0;
    }
}
