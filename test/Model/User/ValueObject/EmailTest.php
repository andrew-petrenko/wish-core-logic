<?php

namespace WishApp\Tests\Model\User\ValueObject;

use PHPUnit\Framework\TestCase;
use WishApp\Model\User\ValueObject\Email;

class EmailTest extends TestCase
{
    public function testCreation()
    {
        $email = new Email('some.email@ex.com');

        $this->assertInstanceOf(Email::class, $email);
    }

    public function testCreationFromString()
    {
        $email = Email::fromString('some.email@ex.com');

        $this->assertInstanceOf(Email::class, $email);
    }

    public function testCreationThrowsOnInvalidEmail()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Email is invalid');

        Email::fromString('asdasd.com.net');
    }

    public function testValue()
    {
        $email = Email::fromString('some.email@ex.com');

        $this->assertEquals('some.email@ex.com', $email->value());
    }

    public function testToString()
    {
        $email = Email::fromString('some.email@ex.com');

        $this->assertEquals('some.email@ex.com', (string) $email);
    }
}
