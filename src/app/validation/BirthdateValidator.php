<?php

namespace App\validation;

class BirthdateValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        if (empty($value)) {
            return false;
        }

        $date = \DateTime::createFromFormat('Y-m-d', $value);

        if (!$date || $date->format('Y-m-d') !== $value) {
            return false;
        }

        $currentDate = new \DateTime();
        $age = $currentDate->diff($date)->y;

        if ($age < 6 || $age > 100) {
            return false;
        }

        return true;
    }
}
