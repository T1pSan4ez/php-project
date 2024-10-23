<?php

namespace App\validation;

class OriginalTitleValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return is_string($value) && strlen($value) >= 3 && strlen($value) <= 255;
    }
}
