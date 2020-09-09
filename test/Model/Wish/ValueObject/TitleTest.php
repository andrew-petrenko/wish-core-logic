<?php

namespace WishApp\Tests\Model\Wish\ValueObject;

use PHPUnit\Framework\TestCase;
use WishApp\Model\Wish\ValueObject\Title;

class TitleTest extends TestCase
{
    public function testCreation()
    {
        $title = new Title('Some title...');

        $this->assertInstanceOf(Title::class, $title);
    }

    public function testCreationFromString()
    {
        $title = Title::fromString('Another title... :)');

        $this->assertInstanceOf(Title::class, $title);
    }

    public function testCreationThrowsIfValueTooShort()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Title is invalid');

        Title::fromString('');
    }

    public function testCreationThrowsIfValueTooLong()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Title is invalid');

        $longString =
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nam nec tincidunt erat, quis vehicula ante. Nulla vitae semper tortor, in posuere erat.
            Aliquam erat volutpat. Proin feugiat elit eu urna finibus vehicula eu eu neque.
            Phasellus interdum dolor eget.';

        Title::fromString($longString);
    }

    public function testValue()
    {
        $title = Title::fromString('Title of something');

        $this->assertIsString($title->value());
        $this->assertEquals('Title of something', $title->value());
    }

    public function testToString()
    {
        $title = Title::fromString('Title of something');

        $this->assertEquals('Title of something', (string) $title);
    }
}
