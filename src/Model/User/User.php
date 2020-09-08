<?php

namespace WishApp\Model\User;

use Ramsey\Uuid\UuidInterface;
use WishApp\Model\User\ValueObject\Email;
use WishApp\Model\User\ValueObject\HashedPassword;
use WishApp\Model\User\ValueObject\PersonalName;

class User
{
    private UuidInterface $uuid;
    private PersonalName $name;
    private Email $email;
    private HashedPassword $hashedPassword;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        UuidInterface $uuid,
        PersonalName $name,
        Email $email,
        HashedPassword $hashedPassword,
        ?\DateTimeImmutable $createdAt = null,
        ?\DateTimeImmutable $updatedAt = null
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = $updatedAt ?? new \DateTimeImmutable();
    }

    public function getId(): UuidInterface
    {
        return $this->uuid;
    }

    public function getName(): PersonalName
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getHashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
