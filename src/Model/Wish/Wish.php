<?php

namespace WishApp\Model\Wish;

use Ramsey\Uuid\UuidInterface;
use WishApp\Model\Wish\ValueObject\Amount;
use WishApp\Model\Wish\ValueObject\Description;
use WishApp\Model\Wish\ValueObject\Title;

class Wish
{
    private UuidInterface $uuid;
    private UuidInterface $userId;
    private Title $title;
    private Amount $amount;
    private ?Description $description;
    private ?\DateTimeImmutable $dueDate;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        UuidInterface $uuid,
        UuidInterface $userId,
        Title $title,
        Amount $amount,
        ?Description $description = null,
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

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getDescription(): Description
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

    public function setTitle(Title $title): void
    {
        $this->title = $title;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function setDescription(?Description $description = null): void
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
