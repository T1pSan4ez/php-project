<?php

namespace App\validation;

class Validator
{
    protected $validators = [
        'username' => UsernameValidator::class,
        'email' => EmailValidator::class,
        'password' => PasswordValidator::class,
    ];

    public function validate(string $fieldType, $value): bool
    {
        if (!isset($this->validators[$fieldType])) {
            throw new \Exception("Validator for field type '{$fieldType}' not found.");
        }

        $validator = new $this->validators[$fieldType];

        if (!($validator instanceof ValidatorInterface)) {
            throw new \Exception("Validator for '{$fieldType}' must implement ValidatorInterface.");
        }

        return $validator->validate($value);
    }
}