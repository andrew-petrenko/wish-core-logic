<?php

namespace WishApp\Util;

abstract class StringValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        /**
         * @see ValidatableValueObject
         */
        if (method_exists($this, 'validate')) {
            $this->validate($value);
        }

        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        return new static($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
