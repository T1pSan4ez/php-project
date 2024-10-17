<?php

namespace App\validation;


class PasswordValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return is_string($value) && strlen($value) >= 6;
    }
}