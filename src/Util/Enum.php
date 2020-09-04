<?php

namespace WishApp\Util;

abstract class Enum
{
    protected string $value;

    public static function __callStatic(string $name, array $args): self
    {
        return new static(strtoupper($name));
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }

    protected function __construct(string $constant)
    {
        $this->value = $constant;
    }
}
