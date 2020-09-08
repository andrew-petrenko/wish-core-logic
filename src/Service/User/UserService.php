<?php

namespace WishApp\Service\User;

use Ramsey\Uuid\Uuid;
use WishApp\Model\User;
use WishApp\Repository\Contracts\UserRepositoryInterface;
use WishApp\Service\User\Contracts\UserServiceInterface;
use WishApp\ValueObject\Email;
use WishApp\ValueObject\HashedPassword;
use WishApp\ValueObject\PersonalName;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(PersonalName $name, Email $email, HashedPassword $hashedPassword): User
    {
        $user = new User(
            Uuid::uuid4(),
            $name,
            $email,
            $hashedPassword
        );
        $this->userRepository->save($user);

        return $user;
    }

    public function doesEmailExist(Email $email): bool
    {
        return $this->userRepository->existWhere(['email' => $email]);
    }

    public function getOneByEmail(Email $email): ?User
    {
        return $this->userRepository->findOneByEmail($email);
    }
}
