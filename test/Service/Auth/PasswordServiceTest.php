<?php

namespace WishApp\Tests\Service\Auth;

use WishApp\Service\Auth\PasswordService;
use WishApp\ValueObject\HashedPassword;
use WishApp\ValueObject\Password;
use PHPUnit\Framework\TestCase;

class PasswordServiceTest extends TestCase
{
    public function testHashReturnsHashedPassword()
    {
        $service = new PasswordService();

        $hash = $service->hash(Password::fromString('Password123'));

        $this->assertInstanceOf(HashedPassword::class, $hash);
    }

    public function testVerify()
    {
        $service = new PasswordService();

        $result = $service->verify(HashedPassword::fromString('123123'), Password::fromString('Password123'));

        $this->assertIsBool($result);
        $this->assertFalse($result);
    }
}
