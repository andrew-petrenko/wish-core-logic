<?php

namespace WishApp\Tests\Service\User;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use WishApp\Model\User\User;
use WishApp\Model\User\ValueObject\Email;
use WishApp\Model\User\ValueObject\HashedPassword;
use WishApp\Model\User\ValueObject\PersonalName;
use WishApp\Repository\Contracts\UserRepositoryInterface;
use WishApp\Service\User\UserService;

class UserServiceTest extends TestCase
{
    private UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);

        parent::setUp();
    }

    public function testCreate()
    {
        $service = new UserService($this->userRepository);
        $result = $service->create(
            PersonalName::fromStrings('Firstname', 'Lastname'),
            Email::fromString('email@ex.com'),
            HashedPassword::fromString('somepasswordhash'),
        );

        $this->assertInstanceOf(User::class, $result);
    }

    public function testDoesEmailExist()
    {
        $email = Email::fromString('email@ex.com');

        $this->userRepository
            ->method('existWhere')
            ->with(['email' => $email])
            ->willReturn(false);

        $service = new UserService($this->userRepository);
        $result = $service->doesEmailExist($email);

        $this->assertIsBool($result);
        $this->assertFalse($result);
    }

    public function testGetOneByEmailReturnsUser()
    {
        $email = Email::fromString('some@ex.com');
        $user = new User(
            Uuid::uuid4(),
            PersonalName::fromStrings('Firstname', 'Lastname'),
            Email::fromString('some@ex.com'),
            HashedPassword::fromString('somehash')
        );

        $this->userRepository
            ->method('findOneByEmail')
            ->with($email)
            ->willReturn($user);

        $service = new UserService($this->userRepository);
        $result = $service->getOneByEmail($email);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($result, $user);
    }

    public function testGetOneByEmailReturnsNull()
    {
        $email = Email::fromString('some@ex.com');
        $this->userRepository
            ->method('findOneByEmail')
            ->with($email)
            ->willReturn(null);

        $service = new UserService($this->userRepository);
        $result = $service->getOneByEmail($email);

        $this->assertNull($result);
    }
}
