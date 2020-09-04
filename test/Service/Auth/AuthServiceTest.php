<?php

namespace WishApp\Tests\Service\Auth;

use WishApp\Model\Exception\ModelNotFoundException;
use WishApp\Model\User;
use WishApp\Service\Auth\AuthService;
use WishApp\Service\Auth\Contracts\PasswordServiceInterface;
use WishApp\Service\Auth\Exception\EmailAlreadyInUseException;
use WishApp\Service\Auth\Exception\InvalidPasswordException;
use WishApp\Service\User\Contracts\UserServiceInterface;
use WishApp\ValueObject\Email;
use WishApp\ValueObject\HashedPassword;
use WishApp\ValueObject\Password;
use WishApp\ValueObject\PersonalName;
use PHPUnit\Framework\TestCase;

class AuthServiceTest extends TestCase
{
    private UserServiceInterface $userService;
    private PasswordServiceInterface $passwordService;

    protected function setUp(): void
    {
        $this->userService = $this->createMock(UserServiceInterface::class);
        $this->passwordService = $this->createMock(PasswordServiceInterface::class);

        parent::setUp();
    }

    public function testSuccessfulRegistrationReturnsUser()
    {
        $authService = new AuthService(
            $this->userService,
            $this->passwordService
        );

        $this->userService
            ->method('doesEmailExist')
            ->willReturn(false);

        $hashedPassword = HashedPassword::fromString('somehashedpassword');

        $this->passwordService
            ->method('hash')
            ->willReturn($hashedPassword);

        $this->userService
            ->method('create')
            ->willReturn($this->createMock(User::class));

        $user = $authService->register(
            PersonalName::fromStrings('Firstname', 'Lastname'),
            Email::fromString('something@ex.com'),
            Password::fromString('Password123')
        );

        $this->assertInstanceOf(User::class, $user);
    }

    public function testCantRegisterIfEmailIsNotUnique()
    {
        $authService = new AuthService(
            $this->userService,
            $this->passwordService
        );

        $this->userService
            ->method('doesEmailExist')
            ->willReturn(true);

        $this->expectException(EmailAlreadyInUseException::class);

        $authService->register(
            PersonalName::fromStrings('Firstname', 'Lastname'),
            Email::fromString('something@ex.com'),
            Password::fromString('Password123')
        );
    }

    public function testSuccessfulLoginReturnsUser()
    {
        $authService = new AuthService(
            $this->userService,
            $this->passwordService
        );

        $this->userService
            ->method('getOneByEmail')
            ->willReturn($this->createMock(User::class));

        $this->passwordService
            ->method('verify')
            ->willReturn(true);

        $user = $authService->login(
            Email::fromString('something@ex.com'),
            Password::fromString('Password123')
        );

        $this->assertInstanceOf(User::class, $user);
    }

    public function testLoginThrowsIfUserNotFound()
    {
        $authService = new AuthService(
            $this->userService,
            $this->passwordService
        );

        $this->userService
            ->method('getOneByEmail')
            ->willReturn(null);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Given email is invalid');

        $authService->login(
            Email::fromString('something@ex.com'),
            Password::fromString('Password123')
        );
    }

    public function testLoginThrowsIfPasswordIsIncorrect()
    {
        $authService = new AuthService(
            $this->userService,
            $this->passwordService
        );

        $this->userService
            ->method('getOneByEmail')
            ->willReturn($this->createMock(User::class));

        $this->passwordService
            ->method('verify')
            ->willReturn(false);

        $this->expectException(InvalidPasswordException::class);

        $authService->login(
            Email::fromString('something@ex.com'),
            Password::fromString('Password123')
        );
    }
}
