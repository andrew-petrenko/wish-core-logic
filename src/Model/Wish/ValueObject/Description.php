<?php

namespace WishApp\Model\Wish\ValueObject;

use WishApp\Util\StringValueObject;
use WishApp\Util\ValidatableValueObject;

class Description extends StringValueObject
{
    use ValidatableValueObject;

    protected static function isValid(string $value): bool
    {
        return preg_match('#^[A-Za-z0-9]{1,1000}#', $value);
    }

    protected static function validationErrorMessage(): string
    {
        return 'Description should be more than 1 symbol but less then 1000';
    }
}
