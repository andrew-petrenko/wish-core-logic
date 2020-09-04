<?php

namespace WishApp\Tests\Service\User;

use WishApp\Model\User;
use WishApp\Repository\Contracts\UserRepositoryInterface;
use WishApp\Repository\Exception\FailedToSaveException;
use WishApp\Service\User\UserService;
use WishApp\ValueObject\Email;
use WishApp\ValueObject\HashedPassword;
use WishApp\ValueObject\PersonalName;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

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

    public function testCreateThrowsOnDatabaseException()
    {
        $this->userRepository
            ->method('save')
            ->with($this->createMock(User::class))
            ->willThrowException(new \Exception());

        $service = new UserService($this->userRepository);

        $this->expectException(FailedToSaveException::class);

        $service->create(
            PersonalName::fromStrings('Firstname', 'Lastname'),
            Email::fromString('some@ex.com'),
            HashedPassword::fromString('somehash')
        );
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
