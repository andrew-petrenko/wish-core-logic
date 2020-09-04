<?php

namespace WishApp\ValueObject;

use WishApp\Util\StringValueObject;
use WishApp\Util\ValidatableValueObject;

class Password extends StringValueObject
{
    use ValidatableValueObject;

    protected static function isValid(string $value): bool
    {
        return preg_match('#^[A-Za-z0-9]{8,32}#', $value);
    }

    protected static function validationErrorMessage(): string
    {
        return 'Password should contain from 8 to 32 characters long';
    }
}
