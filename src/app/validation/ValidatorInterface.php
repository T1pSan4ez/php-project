<?php
namespace App\validation;

interface ValidatorInterface
{
    public function validate($value): bool;
}