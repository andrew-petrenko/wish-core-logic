<?php

namespace WishApp\Model\User\ValueObject;

class PersonalName
{
    private Name $firstName;
    private Name $lastName;

    public function __construct(Name $firstName, Name $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function fromStrings(string $firstName, string $lastName): PersonalName
    {
        return new self(
            new Name($firstName),
            new Name($lastName)
        );
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }
}
