<?php

namespace WishApp\Service\Wish\DTO;

use WishApp\ValueObject\WishDescription;
use WishApp\ValueObject\WishTitle;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CreateWishDTO
{
    private UuidInterface $userId;
    private WishTitle $title;
    private Money $goalAmount;
    private ?WishDescription $description;
    private ?\DateTimeImmutable $dueDate;

    public function __construct(
        UuidInterface $userId,
        WishTitle $title,
        Money $goalAmount,
        ?WishDescription $description = null,
        ?\DateTimeImmutable $dueDate = null
    ) {
        $this->userId = $userId;
        $this->title = $title;
        $this->goalAmount = $goalAmount;
        $this->description = $description;
        $this->dueDate = $dueDate;
    }

    public static function createFromArray(array $params): self
    {
        $params['description'] = $params['description'] ?? null;
        $params['due_date'] = $params['due_date'] ?? null;

        return new self(
            Uuid::fromString($params['user_id']),
            WishTitle::fromString($params['title']),
            Money::USD($params['goal_amount']),
            $params['description'] ? WishDescription::fromString($params['description']) : null,
            $params['due_date'] ? new \DateTimeImmutable($params['due_date']) : null
        );
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function getTitle(): WishTitle
    {
        return $this->title;
    }

    public function getGoalAmount(): Money
    {
        return $this->goalAmount;
    }

    public function getDescription(): WishDescription
    {
        return $this->description;
    }

    public function getDueDate(): \DateTimeImmutable
    {
        return $this->dueDate;
    }
}
