<?php

namespace WishApp\Service\Wish\DTO;

use WishApp\ValueObject\WishDescription;
use WishApp\ValueObject\WishTitle;

class UpdateWishDTO
{
    private ?WishTitle $title;
    private ?WishDescription $description;
    private ?\DateTimeImmutable $dueDate;

    public function __construct(
        ?WishTitle $title = null,
        ?WishDescription $description = null,
        ?\DateTimeImmutable $dueDate = null
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
            $params['title'] ? WishTitle::fromString($params['title']) : null,
            $params['description'] ? WishDescription::fromString($params['description']) : null,
            $params['due_date'] ? new \DateTimeImmutable($params['due_date']) : null
        );
    }

    public function getTitle(): ?WishTitle
    {
        return $this->title;
    }

    public function getDescription(): ?WishDescription
    {
        return $this->description;
    }

    public function getDueDate(): ?\DateTimeImmutable
    {
        return $this->dueDate;
    }
}
