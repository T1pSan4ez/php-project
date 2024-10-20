<?php

namespace App\validation;

class CommentValidator implements ValidatorInterface
{
    private const MAX_LENGTH = 512;

    public function validate($value): bool
    {
        if (is_string($value) && strlen($value) <= self::MAX_LENGTH) {
            return true;
        }

        return false;
    }
}
