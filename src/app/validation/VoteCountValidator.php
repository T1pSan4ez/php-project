<?php

namespace App\validation;

class VoteCountValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return is_numeric($value) && $value >= 0;
    }
}
