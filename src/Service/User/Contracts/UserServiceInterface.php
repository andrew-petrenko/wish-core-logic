<?php

namespace WishApp\Service\User\Contracts;

use WishApp\Model\User;
use WishApp\Repository\Exception\FailedToSaveException;
use WishApp\ValueObject\Email;
use WishApp\ValueObject\HashedPassword;
use WishApp\ValueObject\PersonalName;

interface UserServiceInterface
{
    /**
     * @param PersonalName $name
     * @param Email $email
     * @param HashedPassword $hashedPassword
     * @return User
     * @throws FailedToSaveException
     */
    public function create(PersonalName $name, Email $email, HashedPassword $hashedPassword): User;

    /**
     * @param Email $email
     * @return bool
     */
    public function doesEmailExist(Email $email): bool;

    /**
     * @param Email $email
     * @return User|null
     */
    public function getOneByEmail(Email $email): ?User;
}
