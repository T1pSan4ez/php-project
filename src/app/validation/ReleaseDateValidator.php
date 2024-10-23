<?php

namespace App\validation;

class ReleaseDateValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        $date = date_parse($value);
        return checkdate($date['month'], $date['day'], $date['year']);
    }
}