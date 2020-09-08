<?php

namespace WishApp\Model\User\ValueObject;

use WishApp\Util\StringValueObject;
use WishApp\Util\ValidatableValueObject;

class Email extends StringValueObject
{
    use ValidatableValueObject;

    protected static function isValid(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    protected static function validationErrorMessage(): string
    {
        return 'Email is invalid';
    }
}
