<?php

namespace App\validation;


class PasswordValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return strlen($value) >= 6;
    }
}