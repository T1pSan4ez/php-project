<?php

namespace App\validation;

class UsernameValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return !empty($value);
    }
}