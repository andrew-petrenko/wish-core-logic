<?php

namespace WishApp\Service\Wish\Contracts;

use Money\Money;
use Ramsey\Uuid\UuidInterface;
use WishApp\Model\Exception\ModelNotFoundException;
use WishApp\Model\Wish\Wish;
use WishApp\Model\Wish\WishCollection;
use WishApp\Service\Wish\DTO\CreateWishDTO;
use WishApp\Service\Wish\DTO\UpdateWishDTO;
use WishApp\Service\Wish\Exception\PermissionDeniedException;

interface WishServiceInterface
{
    /**
     * @param CreateWishDTO $createDTO
     * @return Wish
     */
    public function create(CreateWishDTO $createDTO): Wish;

    /**
     * @param UuidInterface $uuid
     * @param UuidInterface $authUserId
     * @param UpdateWishDTO $updateDTO
     * @return Wish
     * @throws ModelNotFoundException
     * @throws PermissionDeniedException
     */
    public function update(UuidInterface $uuid, UuidInterface $authUserId, UpdateWishDTO $updateDTO): Wish;

    /**
     * @param UuidInterface $uuid
     * @param UuidInterface $authUserId
     * @param Money $money
     * @return Wish
     * @throws ModelNotFoundException
     * @throws PermissionDeniedException
     */
    public function changeGoalAmount(UuidInterface $uuid, UuidInterface $authUserId, Money $money): Wish;

    /**
     * @param UuidInterface $uuid
     * @param UuidInterface $authUserId
     * @param Money $money
     * @return Wish
     * @throws ModelNotFoundException
     * @throws PermissionDeniedException
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
