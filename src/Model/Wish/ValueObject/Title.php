<?php

namespace WishApp\Model\Wish\ValueObject;

use WishApp\Util\StringValueObject;
use WishApp\Util\ValidatableValueObject;

class Title extends StringValueObject
{
    use ValidatableValueObject;

    protected static function isValid(string $value): bool
    {
        return preg_match('#^[A-Za-z0-9]{1,255}#', $value);
    }

    protected static function validationErrorMessage(): string
    {
        return 'Title is invalid';
    }
}
