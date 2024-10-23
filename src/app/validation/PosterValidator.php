<?php

namespace App\validation;

class PosterValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($value, PATHINFO_EXTENSION));

        return in_array($fileExtension, $allowedExtensions);
    }
}
