<?php

namespace WishApp\Tests\Service\Auth;

use PHPUnit\Framework\TestCase;
use WishApp\Model\User\ValueObject\HashedPassword;
use WishApp\Model\User\ValueObject\Password;
use WishApp\Service\Auth\PasswordService;

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
