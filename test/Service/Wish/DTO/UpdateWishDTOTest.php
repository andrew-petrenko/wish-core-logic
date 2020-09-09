<?php

namespace WishApp\Tests\Service\Wish\DTO;

use PHPUnit\Framework\TestCase;
use WishApp\Model\Wish\ValueObject\Description;
use WishApp\Model\Wish\ValueObject\DueDate;
use WishApp\Model\Wish\ValueObject\Title;
use WishApp\Service\Wish\DTO\UpdateWishDTO;

class UpdateWishDTOTest extends TestCase
{
    public function testCreation()
    {
        $dto = new UpdateWishDTO();

        $this->assertInstanceOf(UpdateWishDTO::class, $dto);
    }

    public function testCreateFromArray()
    {
        $dto = UpdateWishDTO::createFromArray([]);

        $this->assertInstanceOf(UpdateWishDTO::class, $dto);
    }

    public function testGetTitle()
    {
        $dto = new UpdateWishDTO(
            Title::fromString('Title')
        );

        $this->assertInstanceOf(Title::class, $dto->getTitle());
        $this->assertEquals('Title', $dto->getTitle()->value());
    }

    public function testGetTitleReturnNull()
    {
        $dto = new UpdateWishDTO();

        $this->assertNull($dto->getTitle());
    }

    public function testGetDescription()
    {
        $dto = new UpdateWishDTO(null, Description::fromString('Description'));

        $this->assertInstanceOf(Description::class, $dto->getDescription());
    }

    public function testGetDescriptionReturnNull()
    {
        $dto = new UpdateWishDTO();

        $this->assertNull($dto->getDescription());
    }

    public function testGetDueDate()
    {
        $date = new \DateTimeImmutable();
        $dto = new UpdateWishDTO(null, null, new DueDate($date));

        $this->assertInstanceOf(DueDate::class, $dto->getDueDate());
        $this->assertEquals(
            $date->format('Y-m-d'),
            $dto->getDueDate()->format('Y-m-d')
        );
    }

    public function testGetDueDateReturnNull()
    {
        $dto = new UpdateWishDTO();

        $this->assertNull($dto->getDueDate());
    }
}
