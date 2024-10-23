<?php

namespace App\validation;

class VoteAverageValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return is_numeric($value) && $value >= 0 && $value <= 10;
    }
}