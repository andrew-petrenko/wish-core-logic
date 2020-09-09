<?php

namespace WishApp\Tests\Model\User\ValueObject;

use PHPUnit\Framework\TestCase;
use WishApp\Model\User\ValueObject\Password;

class PasswordTest extends TestCase
{
    public function testCreation()
    {
        $pass = new Password('somepassword123123');

        $this->assertInstanceOf(Password::class, $pass);
    }

    public function testCreationFromString()
    {
        $pass = Password::fromString('somePassword123543');

        $this->assertInstanceOf(Password::class, $pass);
    }

    public function testCreationThrowsOnTooShortPassword()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Password should contain from 8 to 32 characters long and consist only of letters and numbers');

        Password::fromString('qweqwe');
    }

    public function testCreationThrowsOnTooLongPassword()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Password should contain from 8 to 32 characters long and consist only of letters and numbers');

        Password::fromString('123456QWERTYqwerty123456jhgfdsaz2');
    }

    public function testValue()
    {
        $pass = Password::fromString('pass123123');

        $this->assertEquals('pass123123', $pass->value());
    }

    public function testToString()
    {
        $pass = Password::fromString('pass123123');

        $this->assertEquals('pass123123', (string) $pass);
    }
}
