<?php

namespace WishApp\Tests\Service\Auth;

use PHPUnit\Framework\TestCase;
use WishApp\Model\Exception\ModelNotFoundException;
use WishApp\Model\User\User;
use WishApp\Model\User\ValueObject\Email;
use WishApp\Model\User\ValueObject\HashedPassword;
use WishApp\Model\User\ValueObject\Password;
use WishApp\Model\User\ValueObject\PersonalName;
use WishApp\Service\Auth\AuthService;
use WishApp\Service\Auth\Contracts\PasswordServiceInterface;
use WishApp\Service\Auth\Exception\EmailAlreadyInUseException;
use WishApp\Service\Auth\Exception\InvalidPasswordException;
use WishApp\Service\User\Contracts\UserServiceInterface;

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

    public function testRegisterThrowsWhenEmailIsNotUnique()
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
        $this->expectExceptionMessage('User with that email not found');

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
