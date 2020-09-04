<?php

namespace WishApp\Repository\Contracts;

use WishApp\Model\User;
use WishApp\ValueObject\Email;

interface UserRepositoryInterface
{
    /**
     * @param Email $email
     * @return User|null
     */
    public function findOneByEmail(Email $email): ?User;

    /**
     * @param array $criteria
     * @return bool
     */
    public function existWhere(array $criteria): bool;

    /**
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool;
}
