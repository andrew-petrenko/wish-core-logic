<?php

namespace WishApp\Service\Auth;

use WishApp\Model\Exception\ModelNotFoundException;
use WishApp\Model\User;
use WishApp\Service\Auth\Contracts\AuthServiceInterface;
use WishApp\Service\Auth\Contracts\PasswordServiceInterface;
use WishApp\Service\Auth\Exception\EmailAlreadyInUseException;
use WishApp\Service\Auth\Exception\InvalidPasswordException;
use WishApp\Service\User\Contracts\UserServiceInterface;
use WishApp\ValueObject\Email;
use WishApp\ValueObject\Password;
use WishApp\ValueObject\PersonalName;

class AuthService implements AuthServiceInterface
{
    private UserServiceInterface $userService;
    private PasswordServiceInterface $passwordService;

    public function __construct(
        UserServiceInterface $userService,
        PasswordServiceInterface $passwordService
    ) {
        $this->userService = $userService;
        $this->passwordService = $passwordService;
    }

    public function register(PersonalName $name, Email $email, Password $password): User
    {
        if ($this->userService->doesEmailExist($email)) {
            throw new EmailAlreadyInUseException();
        }

        $hashedPassword = $this->passwordService->hash($password);

        return $this->userService->create($name, $email, $hashedPassword);
    }

    public function login(Email $email, Password $password): User
    {
        if (!$user = $this->userService->getOneByEmail($email)) {
            throw new ModelNotFoundException('Given email is invalid');
        }

        if (!$this->passwordService->verify($user->getHashedPassword(), $password)) {
            throw new InvalidPasswordException();
        }

        return $user;
    }
}
