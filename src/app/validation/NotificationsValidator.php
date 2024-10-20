<?php

namespace App\validation;

class NotificationsValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        if (empty($value)) {
            return true;
        }

        if (!is_array($value)) {
            return false;
        }

        $allowedOptions = ['new_movies', 'high_rated_movies'];
        foreach ($value as $option) {
            if (!in_array($option, $allowedOptions, true)) {
                return false;
            }
        }

        return true;
    }
}
