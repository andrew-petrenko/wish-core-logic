<?php

namespace WishApp\Service\Wish;

use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use WishApp\Model\Exception\ModelNotFoundException;
use WishApp\Model\Wish\ValueObject\Amount;
use WishApp\Model\Wish\Wish;
use WishApp\Model\Wish\WishCollection;
use WishApp\Repository\Contracts\WishRepositoryInterface;
use WishApp\Service\Wish\Contracts\WishServiceInterface;
use WishApp\Service\Wish\DTO\CreateWishDTO;
use WishApp\Service\Wish\DTO\UpdateWishDTO;
use WishApp\Service\Wish\Exception\PermissionDeniedException;

/**
 * @TODO how define is user authorized to update/delete some wish?
 *      Simple way - add userId param and check, is that wish related to that wish entity.
 *      In that case we delegate auth functional to "implementation" layer.
 *      Need to research another way of doing that.
 */
class WishService implements WishServiceInterface
{
    private WishRepositoryInterface $wishRepository;

    public function __construct(WishRepositoryInterface $wishRepository)
    {
        $this->wishRepository = $wishRepository;
    }

    public function create(CreateWishDTO $createDTO): Wish
    {
        $wish = new Wish(
            Uuid::uuid4(),
            $createDTO->getUserId(),
            $createDTO->getTitle(),
            new Amount($createDTO->getGoalAmount()),
            $createDTO->getDescription(),
            $createDTO->getDueDate(),
        );
        $this->wishRepository->save($wish);

        return $wish;
    }

    public function update(UuidInterface $uuid, UuidInterface $authUserId, UpdateWishDTO $updateDTO): Wish
    {
        $wish = $this->getOneByIdOrFail($uuid);

        if (!$wish->isBelongsToUser($authUserId)) {
            throw new PermissionDeniedException();
        }

        $wish = new Wish(
            $wish->getId(),
            $authUserId,
            $updateDTO->getTitle(),
            $wish->getAmount(),
            $updateDTO->getDescription(),
            $updateDTO->getDueDate(),
            $wish->getCreatedAt(),
            new \DateTimeImmutable()
        );

        $this->wishRepository->save($wish);

        return $wish;
    }

    public function changeGoalAmount(UuidInterface $uuid, UuidInterface $authUserId, Money $money): Wish
    {
        $wish = $this->getOneByIdOrFail($uuid);

        if (!$wish->isBelongsToUser($authUserId)) {
            throw new PermissionDeniedException();
        }

        $wish->getAmount()->setGoalAmount($money);
        $this->wishRepository->save($wish);

        return $wish;
    }

    public function chargeDepositAmount(UuidInterface $uuid, UuidInterface $authUserId, Money $money): Wish
    {
        $wish = $this->getOneByIdOrFail($uuid);

        if (!$wish->isBelongsToUser($authUserId)) {
            throw new PermissionDeniedException();
        }

        $wish->getAmount()->chargeDeposit($money);
        $this->wishRepository->save($wish);

        return $wish;
    }

    public function getAllByUser(UuidInterface $userId): WishCollection
    {
        return $this->wishRepository->findAllByUserId($userId);
    }

    public function delete(UuidInterface $uuid, UuidInterface $authUserId): void
    {
        $wish = $this->getOneByIdOrFail($uuid);

        if (!$wish->isBelongsToUser($authUserId)) {
            throw new PermissionDeniedException();
        }

        $this->wishRepository->delete($uuid);
    }

    /**
     * @throws ModelNotFoundException
     */
    private function getOneByIdOrFail(UuidInterface $uuid): Wish
    {
        if (!$wish = $this->wishRepository->findOneById($uuid)) {
            throw new ModelNotFoundException('Wish not found');
        }

        return $wish;
    }
}
