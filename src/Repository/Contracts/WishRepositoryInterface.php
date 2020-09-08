<?php

namespace WishApp\Repository\Contracts;

use Ramsey\Uuid\UuidInterface;
use WishApp\Model\Wish\Wish;
use WishApp\Model\Wish\WishCollection;

interface WishRepositoryInterface
{
    /**
     * @param UuidInterface $uuid
     * @return Wish|null
     */
    public function findOneById(UuidInterface $uuid): ?Wish;

    /**
     * @param UuidInterface $uuid
     * @return WishCollection
     */
    public function findAllByUserId(UuidInterface $uuid): WishCollection;

    /**
     * @param Wish $wish
     */
    public function save(Wish $wish): void;

    /**
     * @param UuidInterface $uuid
     */
    public function delete(UuidInterface $uuid): void;
}
