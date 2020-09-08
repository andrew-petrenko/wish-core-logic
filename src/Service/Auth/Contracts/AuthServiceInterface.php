<?php

namespace WishApp\Service\Auth\Contracts;

use WishApp\Model\Exception\ModelNotFoundException;
use WishApp\Model\User\User;
use WishApp\Service\Auth\Exception\EmailAlreadyInUseException;
use WishApp\Service\Auth\Exception\InvalidPasswordException;
use WishApp\Model\User\ValueObject\Email;
use WishApp\Model\User\ValueObject\Password;
use WishApp\Model\User\ValueObject\PersonalName;

interface AuthServiceInterface
{
    /**
     * @param PersonalName $name
     * @param Email $email
     * @param Password $password
     * @return User
     * @throws EmailAlreadyInUseException
     */
    public function register(PersonalName $name, Email $email, Password $password): User;

    /**
     * @param Email $email
     * @param Password $password
     * @return User
     * @throws ModelNotFoundException
     * @throws InvalidPasswordException
     */
    public function login(Email $email, Password $password): User;
}
