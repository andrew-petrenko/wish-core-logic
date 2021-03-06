<?php

namespace WishApp\Service\User\Contracts;

use WishApp\Model\User\User;
use WishApp\Model\User\ValueObject\Email;
use WishApp\Model\User\ValueObject\HashedPassword;
use WishApp\Model\User\ValueObject\PersonalName;

interface UserServiceInterface
{
    /**
     * @param PersonalName $name
     * @param Email $email
     * @param HashedPassword $hashedPassword
     * @return User
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
