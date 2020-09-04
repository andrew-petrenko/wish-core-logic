<?php

namespace WishApp\Tests\Model;

use WishApp\Model\User;
use WishApp\ValueObject\Email;
use WishApp\ValueObject\HashedPassword;
use WishApp\ValueObject\Name;
use WishApp\ValueObject\PersonalName;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserTest extends TestCase
{
    public function testCreation()
    {
        $user = new User(
            Uuid::uuid4(),
            new PersonalName(new Name('Firstname'), new Name('Lastname')),
            new Email('something@ex.com'),
            new HashedPassword('some example hash')
        );

        $this->assertInstanceOf(User::class, $user);
    }

    public function testGetUuid()
    {
        $uuid = Uuid::uuid4();
        $user = new User(
            $uuid,
            new PersonalName(new Name('Firstname'), new Name('Lastname')),
            new Email('something@ex.com'),
            new HashedPassword('some example hash')
        );

        $this->assertInstanceOf(UuidInterface::class, $user->getId());
        $this->assertEquals($uuid->toString(), $user->getId()->toString());
    }

    public function testGetName()
    {
        $personalName = PersonalName::fromStrings('Firstname', 'Lastname');

        $user = new User(
            Uuid::uuid4(),
            $personalName,
            new Email('something@ex.com'),
            new HashedPassword('some example hash')
        );

        $this->assertInstanceOf(PersonalName::class, $user->getName());
        $this->assertEquals('Firstname Lastname', $user->getName());
    }

    public function testGetEmail()
    {
        $email = new Email('something@ex.com');
        $user = new User(
            Uuid::uuid4(),
            new PersonalName(new Name('Firstname'), new Name('Lastname')),
            $email,
            new HashedPassword('some example hash')
        );

        $this->assertInstanceOf(Email::class, $user->getEmail());
        $this->assertEquals('something@ex.com', $user->getEmail()->value());
    }

    public function testGetHashedPassword()
    {
        $hashedPassword = new HashedPassword('SomeHash');

        $user = new User(
            Uuid::uuid4(),
            new PersonalName(new Name('Firstname'), new Name('Lastname')),
            new Email('something@ex.com'),
            $hashedPassword
        );

        $this->assertInstanceOf(HashedPassword::class, $user->getHashedPassword());
        $this->assertEquals('SomeHash', $user->getHashedPassword()->value());
    }
}
