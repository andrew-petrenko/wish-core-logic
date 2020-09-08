<?php

namespace WishApp\Repository\Contracts;

use WishApp\Model\User\User;
use WishApp\Model\User\ValueObject\Email;

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
     */
    public function save(User $user): void;
}
