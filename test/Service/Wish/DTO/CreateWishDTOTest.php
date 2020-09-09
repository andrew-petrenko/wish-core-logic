<?php

namespace WishApp\Tests\Service\Wish\DTO;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use WishApp\Model\Wish\ValueObject\Description;
use WishApp\Model\Wish\ValueObject\DueDate;
use WishApp\Model\Wish\ValueObject\Title;
use WishApp\Service\Wish\DTO\CreateWishDTO;

class CreateWishDTOTest extends TestCase
{
    public function testCreation()
    {
        $dto = new CreateWishDTO(
            Uuid::uuid4(),
            Title::fromString('Title'),
            Money::USD(20)
        );

        $this->assertInstanceOf(CreateWishDTO::class, $dto);
    }

    public function testCreateFromArray()
    {
        $data = [
            'user_id' => '13a52031-589d-4523-8721-e9935c17f16f',
            'title' => 'Some title',
            'goal_amount' => 1000,
            'description' => 'Description for test',
            'due_date' => '2100-01-01'
        ];
        $dto = CreateWishDTO::createFromArray($data);

        $this->assertInstanceOf(CreateWishDTO::class, $dto);
    }

    public function testGetUserId()
    {
        $userId = Uuid::uuid4();
        $dto = new CreateWishDTO(
            $userId,
            Title::fromString('Title'),
            Money::USD(20)
        );

        $this->assertInstanceOf(UuidInterface::class, $dto->getUserId());
        $this->assertEquals($userId->toString(), $dto->getUserId()->toString());
    }

    public function testGetTitle()
    {
        $title = Title::fromString('Title');
        $dto = new CreateWishDTO(
            Uuid::uuid4(),
            $title,
            Money::USD(20)
        );

        $this->assertInstanceOf(Title::class, $dto->getTitle());
        $this->assertEquals($title->value(), $dto->getTitle()->value());
    }

    public function testGetGoalAmount()
    {
        $amount = Money::USD(20);
        $dto = new CreateWishDTO(
            Uuid::uuid4(),
            Title::fromString('Title'),
            $amount
        );

        $this->assertInstanceOf(Money::class, $dto->getGoalAmount());
        $this->assertEquals($amount->getAmount(), $dto->getGoalAmount()->getAmount());
    }

    public function testGetDescription()
    {
        $description = Description::fromString('Description');
        $dto = new CreateWishDTO(
            Uuid::uuid4(),
            Title::fromString('Title'),
            Money::USD(20),
            $description
        );

        $this->assertInstanceOf(Description::class, $description);
        $this->assertEquals($description->value(), $dto->getDescription()->value());
    }

    public function testGetDescriptionReturnNull()
    {
        $dto = new CreateWishDTO(
            Uuid::uuid4(),
            Title::fromString('Title'),
            Money::USD(20),
            null
        );

        $this->assertNull($dto->getDescription());
    }

    public function testGetDueDate()
    {
        $date = new \DateTimeImmutable();
        $dto = new CreateWishDTO(
            Uuid::uuid4(),
            Title::fromString('Title'),
            Money::USD(20),
            Description::fromString('Description'),
            new DueDate($date)
        );

        $this->assertInstanceOf(DueDate::class, $dto->getDueDate());
        $this->assertEquals(
            $date->format('Y-m-d'),
            $dto->getDueDate()->format('Y-m-d')
        );
    }

    public function testGetDueDateReturnNull()
    {
        $dto = new CreateWishDTO(
            Uuid::uuid4(),
            Title::fromString('Title'),
            Money::USD(20),
            Description::fromString('Description'),
            null
        );

        $this->assertNull($dto->getDueDate());
    }
}
