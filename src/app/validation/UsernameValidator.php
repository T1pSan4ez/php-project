<?php

namespace App\validation;

class UsernameValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return !empty($value) && strlen($value) >= 3 && strlen($value) <= 32 ;
    }
}