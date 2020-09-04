<?php

namespace WishApp\ValueObject;

class DateOfBirth
{
    private \DateTimeImmutable $value;

    public function __construct(\DateTimeImmutable $date)
    {
        if (!self::isValid($date)) {
            throw new \InvalidArgumentException('Invalid date');
        }

        $this->value = $date;
    }

    public function format(string $pattern): string
    {
        return $this->value->format($pattern);
    }

    public function value(): \DateTimeImmutable
    {
        return $this->value;
    }

    private static function isValid(\DateTimeImmutable $date): bool
    {
        return (new \DateTimeImmutable())->format('Y') > $date->format('Y');
    }
}
