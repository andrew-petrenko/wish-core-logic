<?php

namespace WishApp\Model\Wish\ValueObject;

class DueDate
{
    private const DEFAULT_FORMAT = 'Y-m-d';
    private \DateTimeImmutable $value;

    public function __construct(\DateTimeImmutable $date)
    {
        $this->value = $date->setTime(0, 0, 0, 0);
    }

    public function value(): \DateTimeImmutable
    {
        return $this->value;
    }

    public function format(string $pattern = self::DEFAULT_FORMAT): string
    {
        return $this->value->format($pattern);
    }
}
