<?php

namespace WishApp\Service\Wish\Contracts;

use WishApp\Model\Exception\ModelNotFoundException;
use WishApp\Model\Wish;
use WishApp\Model\WishCollection;
use WishApp\Repository\Exception\FailedToSaveException;
use WishApp\Service\Wish\DTO\CreateWishDTO;
use WishApp\Service\Wish\DTO\UpdateWishDTO;
use WishApp\Service\Wish\Exception\PermissionDeniedException;
use Money\Money;
use Ramsey\Uuid\UuidInterface;

interface WishServiceInterface
{
    /**
     * @param CreateWishDTO $createDTO
     * @return Wish
     * @throws FailedToSaveException
     */
    public function create(CreateWishDTO $createDTO): Wish;

    /**
     * @param UuidInterface $uuid
     * @param UuidInterface $authUserId
     * @param UpdateWishDTO $updateDTO
     * @return Wish
     * @throws ModelNotFoundException
     * @throws PermissionDeniedException
     * @throws FailedToSaveException
     */
    public function update(UuidInterface $uuid, UuidInterface $authUserId, UpdateWishDTO $updateDTO): Wish;

    /**
     * @param UuidInterface $uuid
     * @param UuidInterface $authUserId
     * @param Money $money
     * @return Wish
     * @throws ModelNotFoundException
     * @throws PermissionDeniedException
     * @throws FailedToSaveException
     */
    public function changeGoalAmount(UuidInterface $uuid, UuidInterface $authUserId, Money $money): Wish;

    /**
     * @param UuidInterface $uuid
     * @param UuidInterface $authUserId
     * @param Money $money
     * @return Wish
     * @throws ModelNotFoundException
     * @throws PermissionDeniedException
     * @throws FailedToSaveException
     */
    public function chargeDepositAmount(UuidInterface $uuid, UuidInterface $authUserId, Money $money): Wish;

    /**
     * @param UuidInterface $userId
     * @return WishCollection
     */
    public function getAllByUser(UuidInterface $userId): WishCollection;

    /**
     * @param UuidInterface $uuid
     * @param UuidInterface $authUserId
     * @throws ModelNotFoundException
     * @throws PermissionDeniedException
     */
    public function delete(UuidInterface $uuid, UuidInterface $authUserId): void;
}
