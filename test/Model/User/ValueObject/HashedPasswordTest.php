<?php

namespace WishApp\Tests\Model\User\ValueObject;

use PHPUnit\Framework\TestCase;
use WishApp\Model\User\ValueObject\HashedPassword;

class HashedPasswordTest extends TestCase
{
    public function testCreation()
    {
        $hash = new HashedPassword('Some value');

        $this->assertInstanceOf(HashedPassword::class, $hash);
    }

    public function testCreationFromString()
    {
        $hash = HashedPassword::fromString('Some value');

        $this->assertInstanceOf(HashedPassword::class, $hash);
    }

    public function testValue()
    {
        $hash = HashedPassword::fromString('Some value');

        $this->assertEquals('Some value', $hash->value());
    }

    public function testToString()
    {
        $hash = HashedPassword::fromString('Some value');

        $this->assertEquals('Some value', $hash->value());
    }
}
