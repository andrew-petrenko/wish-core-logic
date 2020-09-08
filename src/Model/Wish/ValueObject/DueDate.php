<?php

namespace WishApp\Model\Wish\ValueObject;

class DueDate
{
    private const DEFAULT_FORMAT = 'Y-m-d';
    private \DateTimeImmutable $value;

    public function __construct(\DateTimeImmutable $date)
    {
        $today = (new \DateTimeImmutable())->setTime(0, 0, 0, 0);
        $date->setTime(0, 0, 0, 0);

        if ($date->diff($today)->invert) {
            throw new \InvalidArgumentException('Due date can\'t be earlier then tomorrow');
        }

        $this->value = $date;
    }

    public function value(): \DateTimeImmutable
    {
        return $this->value;
    }

    public function format(?string $pattern = null): string
    {
        return $pattern
            ? $this->value->format($pattern)
            : $this->value->format(self::DEFAULT_FORMAT);
    }
}
