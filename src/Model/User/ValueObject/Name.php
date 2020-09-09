<?php

namespace WishApp\Model\User\ValueObject;

use WishApp\Util\StringValueObject;
use WishApp\Util\ValidatableValueObject;

class Name extends StringValueObject
{
    use ValidatableValueObject;

    protected static function isValid(string $value): bool
    {
        return preg_match('#^[A-Za-z]{1,35}$#', $value);
    }

    protected static function validationErrorMessage(): string
    {
        return 'Name is invalid';
    }
}
