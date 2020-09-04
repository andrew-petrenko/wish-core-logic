<?php

namespace WishApp\Service\Auth;

use WishApp\Service\Auth\Contracts\PasswordServiceInterface;
use WishApp\ValueObject\HashedPassword;
use WishApp\ValueObject\Password;

class PasswordService implements PasswordServiceInterface
{
    protected static string $cryptAlgo = PASSWORD_BCRYPT;

    public function hash(Password $password): HashedPassword
    {
        $hash = password_hash($password, static::$cryptAlgo);

        return new HashedPassword($hash);
    }

    public function verify(HashedPassword $hash, Password $password): bool
    {
        return password_verify($password, $hash);
    }
}
