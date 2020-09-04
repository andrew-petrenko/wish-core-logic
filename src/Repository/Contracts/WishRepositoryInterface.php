<?php

namespace WishApp\Repository\Contracts;

use WishApp\Model\Wish;
use WishApp\Model\WishCollection;
use Exception;
use Ramsey\Uuid\UuidInterface;

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
     * @throws Exception
     */
    public function save(Wish $wish): void;

    /**
     * @param UuidInterface $uuid
     */
    public function delete(UuidInterface $uuid): void;
}
