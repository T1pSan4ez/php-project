<?php

namespace App\validation;

class ProfileImageValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        if (empty($value['name'])) {
            return true;
        }

        if ($value['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($value['type'], $allowedTypes)) {
            return false;
        }

        if ($value['size'] > 2 * 1024 * 1024) {
            return false;
        }

        return true;
    }
}
