<?php

namespace WishApp\Service\Wish\DTO;

use WishApp\Model\Wish\ValueObject\Description;
use WishApp\Model\Wish\ValueObject\DueDate;
use WishApp\Model\Wish\ValueObject\Title;

class UpdateWishDTO
{
    private ?Title $title;
    private ?Description $description;
    private ?DueDate $dueDate;

    public function __construct(
        ?Title $title = null,
        ?Description $description = null,
        ?DueDate $dueDate = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->dueDate = $dueDate;
    }

    public static function createFromArray(array $params): self
    {
        $params['title'] = $params['title'] ?? null;
        $params['description'] = $params['description'] ?? null;
        $params['due_date'] = $params['due_date'] ?? null;

        return new self(
            $params['title'] ? Title::fromString($params['title']) : null,
            $params['description'] ? Description::fromString($params['description']) : null,
            $params['due_date'] ? new DueDate(new \DateTimeImmutable($params['due_date'])) : null
        );
    }

    public function getTitle(): ?Title
    {
        return $this->title;
    }

    public function getDescription(): ?Description
    {
        return $this->description;
    }

    public function getDueDate(): ?DueDate
    {
        return $this->dueDate;
    }
}
