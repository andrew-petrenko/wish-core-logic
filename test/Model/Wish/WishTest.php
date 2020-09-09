<?php

namespace WishApp\Tests\Model\Wish;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use WishApp\Model\Wish\ValueObject\Amount;
use WishApp\Model\Wish\ValueObject\Description;
use WishApp\Model\Wish\ValueObject\DueDate;
use WishApp\Model\Wish\ValueObject\Title;
use WishApp\Model\Wish\Wish;

class WishTest extends TestCase
{
    public function testCreation()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(10000)),
            Description::fromString('Some description'),
            new DueDate(new \DateTimeImmutable())
        );

        $this->assertInstanceOf(Wish::class, $wish);
    }

    public function testGetId()
    {
        $uuid = Uuid::uuid4();
        $wish = new Wish(
            $uuid,
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(10000))
        );

        $this->assertInstanceOf(UuidInterface::class, $wish->getId());
        $this->assertEquals($uuid->toString(), $wish->getId()->toString());
    }

    public function testGetUserId()
    {
        $userId = Uuid::uuid4();
        $wish = new Wish(
            Uuid::uuid4(),
            $userId,
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
        );

        $this->assertInstanceOf(UuidInterface::class, $wish->getUserId());
        $this->assertEquals(
            $userId->toString(),
            $wish->getUserId()->toString()
        );
    }

    public function testGetTitle()
    {
        $title = new Title('Some title');

        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            $title,
            new Amount(Money::USD(10000))
        );

        $this->assertInstanceOf(Title::class, $wish->getTitle());
        $this->assertEquals($title->value(), $wish->getTitle()->value());
    }

    public function testGetAmount()
    {
        $amount = new Amount(Money::USD(15000));

        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            $amount,
            Description::fromString('Some description')
        );

        $this->assertInstanceOf(Amount::class, $wish->getAmount());
    }

    public function testGetGoalAmount()
    {
        $amount = new Amount(Money::USD(15000));

        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            $amount,
            Description::fromString('Some description')
        );

        $this->assertInstanceOf(Money::class, $wish->getGoalAmount());
        $this->assertEquals(15000, $wish->getGoalAmount()->getAmount());
    }

    public function testGetDepositedAmount()
    {
        $amount = new Amount(Money::USD(15000), Money::USD(1000));

        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            $amount,
            Description::fromString('Some description')
        );

        $this->assertInstanceOf(Money::class, $wish->getDepositedAmount());
        $this->assertEquals(1000, $wish->getDepositedAmount()->getAmount());
    }

    public function testGetDescriptionWhenItExist()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
            Description::fromString('Some description')
        );

        $this->assertInstanceOf(Description::class, $wish->getDescription());
    }

    public function testGetDescriptionWhenItDoesNotExist()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
            null
        );

        $this->assertNull($wish->getDescription());
    }

    public function testGetDueDateWhenItExist()
    {
        $dateTime = (new \DateTimeImmutable());
        $dueDate = new DueDate($dateTime);

        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
            Description::fromString('Some description'),
            $dueDate
        );

        $this->assertInstanceOf(DueDate::class, $wish->getDueDate());
        $this->assertEquals(
            $dateTime->format('Y-m-d'),
            $dueDate->format('Y-m-d')
        );
    }

    public function testGetDueDateWhenItDoesNotExist()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
            Description::fromString('Some description'),
            null
        );

        $this->assertNull($wish->getDueDate());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new \DateTimeImmutable();
        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
            Description::fromString('Some description'),
            new DueDate(new \DateTimeImmutable()),
            $createdAt
        );

        $this->assertInstanceOf(\DateTimeImmutable::class, $wish->getCreatedAt());
        $this->assertEquals(
            $createdAt->format('Y-m-d H:i:s'),
            $wish->getCreatedAt()->format('Y-m-d H:i:s')
        );
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new \DateTimeImmutable();
        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
            Description::fromString('Some description'),
            new DueDate(new \DateTimeImmutable()),
            new \DateTimeImmutable(),
            $updatedAt
        );

        $this->assertInstanceOf(\DateTimeImmutable::class, $wish->getUpdatedAt());
        $this->assertEquals(
            $updatedAt->format('Y-m-d H:i:s'),
            $wish->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }

    public function testSetTitle()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
        );

        $newTitle = Title::fromString('NEW TITLE');
        $wish->setTitle($newTitle);

        $this->assertEquals(
            'NEW TITLE',
            $wish->getTitle()->value()
        );
    }

    public function testSetDescription()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
        );

        $newDescription = Description::fromString('NEW DESCRIPTION');
        $wish->setDescription($newDescription);

        $this->assertEquals(
            'NEW DESCRIPTION',
            $wish->getDescription()->value()
        );
    }

    public function testSetDueDate()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
        );

        $this->assertNull($wish->getDueDate());

        $tomorrow = (new \DateTimeImmutable())->modify('+ 1 day');
        $newDueDate = new DueDate($tomorrow);
        $wish->setDueDate($newDueDate);

        $this->assertNotNull($wish->getDueDate());
        $this->assertInstanceOf(DueDate::class, $wish->getDueDate());
    }

    public function testIsBelongsToUserReturnTrue()
    {
        $userId = Uuid::uuid4();
        $wish = new Wish(
            Uuid::uuid4(),
            $userId,
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
        );

        $this->assertTrue($wish->isBelongsToUser($userId));
    }

    public function testIsBelongsToUserReturnFalse()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
        );

        $this->assertFalse($wish->isBelongsToUser(Uuid::uuid4()));
    }

    public function testIsActualReturnTrueWhenDueDateIsNull()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
        );

        $this->assertTrue($wish->isActual());
    }

    public function testIsActualReturnTrueWhenDueDateMoreThanToday()
    {
        $tomorrow = (new \DateTimeImmutable())->modify('+ 1 day');
        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
            Description::fromString('Some description'),
            new DueDate($tomorrow)
        );

        $this->assertTrue($wish->isActual());
    }

    public function testIsActualReturnFalseWhenDueDateTodayOrLess()
    {
        $today = new \DateTimeImmutable();
        $wish = new Wish(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Title::fromString('Some title'),
            new Amount(Money::USD(15000)),
            Description::fromString('Some description'),
            new DueDate($today)
        );

        $this->assertFalse($wish->isActual());
    }
}
