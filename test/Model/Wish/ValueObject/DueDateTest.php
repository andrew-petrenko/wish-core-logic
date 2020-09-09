<?php

namespace WishApp\Tests\Model\Wish\ValueObject;

use PHPUnit\Framework\TestCase;
use WishApp\Model\Wish\ValueObject\DueDate;

class DueDateTest extends TestCase
{
    public function testCreation()
    {
        $dueDate = new DueDate(new \DateTimeImmutable());

        $this->assertInstanceOf(DueDate::class, $dueDate);
    }

    public function testValue()
    {
        $tomorrow = (new \DateTimeImmutable())->modify('+ 1 day');
        $dueDate = new DueDate(new \DateTimeImmutable());

        $this->assertInstanceOf(\DateTimeImmutable::class, $dueDate->value());
    }

    public function testFormatWithDefaultPattern()
    {
        $dateTime = new \DateTimeImmutable();
        $dueDate = new DueDate($dateTime);

        $ref = new \ReflectionClass($dueDate);
        $defaultFormat = $ref->getConstant('DEFAULT_FORMAT');

        $this->assertEquals(
            $dateTime->format($defaultFormat),
            $dueDate->format()
        );
        $this->assertIsString($dueDate->format());
    }

    public function testFormatWithCustomPattern()
    {
        $dateTime = new \DateTimeImmutable();
        $dueDate = new DueDate($dateTime);

        $this->assertEquals(
            $dateTime->format('Y/m/d'),
            $dueDate->format('Y/m/d')
        );
        $this->assertIsString($dueDate->format('Y/m/d'));
    }
}
