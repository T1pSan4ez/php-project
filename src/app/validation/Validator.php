<?php

namespace App\validation;

class Validator
{
    protected $validators = [
        'username' => UsernameValidator::class,
        'email' => EmailValidator::class,
        'password' => PasswordValidator::class,
        'preferred_rating' => PreferredRatingValidator::class,
        'birthdate' => BirthdateValidator::class,
        'gender' => GenderValidator::class,
        'notifications' => NotificationsValidator::class,
        'profile_image' => ProfileImageValidator::class,

        'original_title' => OriginalTitleValidator::class,
        'title' => TitleValidator::class,
        'overview' => OverviewValidator::class,
        'release_date' => ReleaseDateValidator::class,
        'vote_average' => VoteAverageValidator::class,
        'vote_count' => VoteCountValidator::class,
        'popularity' => PopularityValidator::class,
        'original_language' => OriginalLanguageValidator::class,
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
