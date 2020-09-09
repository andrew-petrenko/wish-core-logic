<?php

namespace WishApp\Tests\Model\User;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use WishApp\Model\User\User;
use WishApp\Model\User\ValueObject\Email;
use WishApp\Model\User\ValueObject\HashedPassword;
use WishApp\Model\User\ValueObject\Name;
use WishApp\Model\User\ValueObject\PersonalName;

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

    public function testGetCreatedAt()
    {
        $createdAt = new \DateTimeImmutable();

        $user = new User(
            Uuid::uuid4(),
            new PersonalName(new Name('Firstname'), new Name('Lastname')),
            new Email('something@ex.com'),
            new HashedPassword('some example hash'),
            $createdAt
        );

        $this->assertInstanceOf(\DateTimeImmutable::class, $user->getCreatedAt());
        $this->assertEquals($createdAt, $user->getCreatedAt());
        $this->assertEquals(
            $createdAt->format('Y-m-d H:i:s'),
            $user->getCreatedAt()->format('Y-m-d H:i:s')
        );
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new \DateTimeImmutable();

        $user = new User(
            Uuid::uuid4(),
            new PersonalName(new Name('Firstname'), new Name('Lastname')),
            new Email('something@ex.com'),
            new HashedPassword('some example hash'),
            new \DateTimeImmutable(),
            $updatedAt
        );

        $this->assertInstanceOf(\DateTimeImmutable::class, $user->getUpdatedAt());
        $this->assertEquals($updatedAt, $user->getUpdatedAt());
        $this->assertEquals(
            $updatedAt->format('Y-m-d H:i:s'),
            $user->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
