<?php

namespace WishApp\Tests\Model;

use WishApp\Model\Wish;
use WishApp\Service\Wish\WishUpdateDTO;
use WishApp\ValueObject\WishTitle;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class WishTest extends TestCase
{
    public function testTest()
    {
        $this->assertFalse(false);
    }

    public function testCreation()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            new WishTitle('Some title'),
            new Money(20000, new Currency('USD')),
            new \DateTimeImmutable('2020-05-05 15:10')
        );

        $this->assertInstanceOf(Wish::class, $wish);
    }

    public function testGetUuid()
    {
        $uuid = Uuid::uuid4();
        $wish = new Wish(
            $uuid,
            new WishTitle('Some title')
        );

        $this->assertInstanceOf(UuidInterface::class, $wish->getId());
        $this->assertEquals($uuid->toString(), $wish->getId()->toString());
    }

    public function testGetTitle()
    {
        $title = new WishTitle('Some title');

        $wish = new Wish(
            Uuid::uuid4(),
            $title
        );

        $this->assertInstanceOf(WishTitle::class, $wish->getTitle());
        $this->assertEquals($title->value(), $wish->getTitle()->value());
    }

    public function testGetAmountWhenItExists()
    {
        $amount = new Money(15000, new Currency('USD'));

        $wish = new Wish(
            Uuid::uuid4(),
            new WishTitle('Some title'),
            $amount,
        );

        $this->assertInstanceOf(Money::class, $wish->getAmount());
        $this->assertEquals(15000, $wish->getAmount()->getAmount());
    }

    public function testGetAmountWhenItDoesNotExist()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            new WishTitle('Some title')
        );

        $this->assertInstanceOf(Money::class, $wish->getAmount());
        $this->assertEquals(0, $wish->getAmount()->getAmount());
    }

    public function testGetDueDateWhenItExists()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            new WishTitle('Some title'),
            new Money(20000, new Currency('USD')),
            new \DateTimeImmutable('2020-05-05 15:10')
        );

        $this->assertInstanceOf(\DateTimeImmutable::class, $wish->getDueDate());
        $this->assertEquals('2020-05-05 15:10', $wish->getDueDate()->format('Y-m-d H:i'));
    }

    public function testGetDueDateWhenItDoesNotExist()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            new WishTitle('Some title')
        );

        $this->assertNull($wish->getDueDate());
    }

    public function testChangeTitle()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            new WishTitle('Some title')
        );
        $newTitle = new WishTitle('Updated title');
        $wish->setTitle($newTitle);

        $this->assertEquals('Updated title', $wish->getTitle()->value());
    }

    public function testChangeAmount()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            new WishTitle('Some title'),
            new Money(20000, new Currency('USD'))
        );
        $newAmount = new Money(10000, new Currency('USD'));
        $wish->changeAmount($newAmount);

        $this->assertEquals(10000, $wish->getAmount()->getAmount());
    }

    public function testChangeDueDate()
    {
        $wish = new Wish(
            Uuid::uuid4(),
            new WishTitle('Some title'),
            new Money(20000, new Currency('USD')),
            new \DateTimeImmutable('2020-05-05 15:10')
        );
        $newDueDate = new \DateTimeImmutable('2021-01-01 12:12');
        $wish->setDueDate($newDueDate);

        $this->assertEquals('2021-01-01 12:12', $wish->getDueDate()->format('Y-m-d H:i'));
    }
}
