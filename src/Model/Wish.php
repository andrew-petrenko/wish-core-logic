<?php

namespace WishApp\Model;

use WishApp\ValueObject\WishAmount;
use WishApp\ValueObject\WishDescription;
use WishApp\ValueObject\WishTitle;
use Ramsey\Uuid\UuidInterface;

class Wish
{
    private UuidInterface $uuid;
    private UuidInterface $userId;
    private WishTitle $title;
    private WishAmount $amount;
    private ?WishDescription $description;
    private ?\DateTimeImmutable $dueDate;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        UuidInterface $uuid,
        UuidInterface $userId,
        WishTitle $title,
        WishAmount $amount,
        ?WishDescription $description = null,
        ?\DateTimeImmutable $dueDate = null,
        ?\DateTimeImmutable $createdAt = null,
        ?\DateTimeImmutable $updatedAt = null
    ) {
        $this->uuid = $uuid;
        $this->userId = $userId;
        $this->title = $title;
        $this->amount = $amount;
        $this->description = $description;
        $this->dueDate = $dueDate;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = $updatedAt ?? new \DateTimeImmutable();
    }

    public function getId(): UuidInterface
    {
        return $this->uuid;
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function getTitle(): WishTitle
    {
        return $this->title;
    }

    public function getAmount(): WishAmount
    {
        return $this->amount;
    }

    public function getDescription(): WishDescription
    {
        return $this->description;
    }

    public function getDueDate(): ?\DateTimeImmutable
    {
        return $this->dueDate;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setTitle(WishTitle $title): void
    {
        $this->title = $title;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function setDescription(?WishDescription $description = null): void
    {
        $this->description = $description;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function setDueDate(?\DateTimeImmutable $dueDate = null): void
    {
        $this->dueDate = $dueDate;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function isBelongsToUser(UuidInterface $userId): bool
    {
        return $this->userId->equals($userId);
    }

    public function isActual(): bool
    {
        return is_null($this->dueDate) ?: !(new \DateTimeImmutable())->diff($this->dueDate)->invert;
    }
}
