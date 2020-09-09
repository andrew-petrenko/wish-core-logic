<?php

namespace WishApp\Model\Wish;

class WishCollection
{
    /**
     * @var Wish[]|array
     */
    private array $items;

    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            if (!$item instanceof Wish) {
                throw new \InvalidArgumentException('WishCollection should contain only Wish instances');
            }
        }

        $this->items = $items;
    }

    public function add(Wish $wish): void
    {
        $this->items[] = $wish;
    }

    /**
     * @return Wish[]|array
     */
    public function all(): array
    {
        return $this->items;
    }
}
