<?php

namespace WishApp\Tests\Model\User\ValueObject;

use PHPUnit\Framework\TestCase;
use WishApp\Model\User\ValueObject\Name;

class NameTest extends TestCase
{
    public function testCreation()
    {
        $name = new Name('Firstname');

        $this->assertInstanceOf(Name::class, $name);
    }

    public function testCreationFromString()
    {
        $name = Name::fromString('Firstname');

        $this->assertInstanceOf(Name::class, $name);
    }

    public function testCreationThrowsOnInvalidInput()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Name is invalid');

        Name::fromString('Name789');
    }

    public function testCreationThrowsOnTooShortName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Name is invalid');

        Name::fromString('');
    }

    public function testCreationThrowsOnTooLongName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Name is invalid');

        Name::fromString('SomeverylongnameIdontknowifitexistornot');
    }

    public function testValue()
    {
        $name = Name::fromString('Firstname');

        $this->assertEquals('Firstname', $name->value());
    }

    public function testToString()
    {
        $name = Name::fromString('Firstname');

        $this->assertEquals('Firstname', (string) $name);
    }
}
