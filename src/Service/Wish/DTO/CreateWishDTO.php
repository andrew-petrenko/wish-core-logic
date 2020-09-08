<?php

namespace WishApp\Service\Wish\DTO;

use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use WishApp\Model\Wish\ValueObject\Description;
use WishApp\Model\Wish\ValueObject\Title;

class CreateWishDTO
{
    private UuidInterface $userId;
    private Title $title;
    private Money $goalAmount;
    private ?Description $description;
    private ?\DateTimeImmutable $dueDate;

    public function __construct(
        UuidInterface $userId,
        Title $title,
        Money $goalAmount,
        ?Description $description = null,
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
            Title::fromString($params['title']),
            Money::USD($params['goal_amount']),
            $params['description'] ? Description::fromString($params['description']) : null,
            $params['due_date'] ? new \DateTimeImmutable($params['due_date']) : null
        );
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getGoalAmount(): Money
    {
        return $this->goalAmount;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getDueDate(): \DateTimeImmutable
    {
        return $this->dueDate;
    }
}
