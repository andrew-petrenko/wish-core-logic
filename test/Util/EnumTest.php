<?php

namespace WishApp\Tests\Util;

use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function testCreation()
    {
        $enum = EnumStub::test();

        $this->assertInstanceOf(EnumStub::class, $enum);
    }

    public function testValue()
    {
        $enum = EnumStub::test();

        $this->assertEquals('TEST', $enum->value());
    }

    public function testToString()
    {
        $enum = EnumStub::test();

        $this->assertEquals('TEST', (string) $enum);
    }
}
