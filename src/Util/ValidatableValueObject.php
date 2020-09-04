<?php

namespace WishApp\Util;

trait ValidatableValueObject
{
    protected function validate($value): void
    {
        if (!static::isValid($value)) {
            throw new \InvalidArgumentException(static::validationErrorMessage());
        }
    }

    abstract protected static function isValid($value): bool;

    abstract protected static function validationErrorMessage(): string;
}
