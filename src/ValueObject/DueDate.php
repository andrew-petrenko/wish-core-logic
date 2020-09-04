<?php

namespace WishApp\ValueObject;

class DueDate
{
    private \DateTimeImmutable $value;

    public function __construct(\DateTimeImmutable $date)
    {
        if ($date->diff(new \DateTimeImmutable())->invert) {
            throw new \Exception('Due date can\'t be earlier then tomorrow');
        }

        $this->value = $date;
    }

    public function value(): \DateTimeImmutable
    {
        return $this->value;
    }
}
