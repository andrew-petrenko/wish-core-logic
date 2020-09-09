<?php

namespace WishApp\Tests\Model\User\ValueObject;

use PHPUnit\Framework\TestCase;
use WishApp\Model\User\ValueObject\Name;
use WishApp\Model\User\ValueObject\PersonalName;

class PersonalNameTest extends TestCase
{
    public function testCreation()
    {
        $personalName = new PersonalName(Name::fromString('Firstname'), Name::fromString('Lastname'));

        $this->assertInstanceOf(PersonalName::class, $personalName);
    }

    public function testCreationFromStrings()
    {
        $personalName = PersonalName::fromStrings('Firstname', 'Lastname');

        $this->assertInstanceOf(PersonalName::class, $personalName);
    }

    public function testGetFirstName()
    {
        $personalName = PersonalName::fromStrings('Firstname', 'Lastname');

        $this->assertInstanceOf(Name::class, $personalName->getFirstName());
        $this->assertEquals('Firstname', (string) $personalName->getFirstName());
    }

    public function testGetLastName()
    {
        $personalName = PersonalName::fromStrings('Firstname', 'Lastname');

        $this->assertInstanceOf(Name::class, $personalName->getLastName());
        $this->assertEquals('Lastname', (string) $personalName->getLastName());
    }

    public function testGetFormattedFullName()
    {
        $personalName = PersonalName::fromStrings('Firstname', 'Lastname');

        $this->assertIsString($personalName->getFormattedFullName());
        $this->assertEquals('Firstname Lastname', $personalName->getFormattedFullName());
    }

    public function testToStringReturnsFormattedFullName()
    {
        $personalName = PersonalName::fromStrings('Firstname', 'Lastname');

        $this->assertEquals('Firstname Lastname', (string) $personalName);
    }
}
