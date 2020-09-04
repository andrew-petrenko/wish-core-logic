<?php

namespace WishApp\Service\Auth\Contracts;

use WishApp\ValueObject\HashedPassword;
use WishApp\ValueObject\Password;

interface PasswordServiceInterface
{
    /**
     * @param Password $password
     * @return HashedPassword
     */
    public function hash(Password $password): HashedPassword;

    /**
     * @param HashedPassword $hash
     * @param Password $password
     * @return bool
     */
    public function verify(HashedPassword $hash, Password $password): bool;
}
