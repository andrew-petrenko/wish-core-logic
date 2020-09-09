<?php

namespace WishApp\Tests\Model\Wish;

use PHPUnit\Framework\TestCase;
use WishApp\Model\Wish\Wish;
use WishApp\Model\Wish\WishCollection;

class WishCollectionTest extends TestCase
{
    public function testCreation()
    {
        $collection = new WishCollection();

        $this->assertInstanceOf(WishCollection::class, $collection);
    }

    public function testCreationWithItem()
    {
        $items = [
            $this->createMock(Wish::class),
            $this->createMock(Wish::class)
        ];
        $collection = new WishCollection($items);

        $this->assertInstanceOf(WishCollection::class, $collection);
    }

    public function testCreationThrowsWithInvalidItem()
    {
        $invalidItems = [
            $this->createMock(Wish::class),
            new \Stdclass
        ];
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('WishCollection should contain only Wish instances');

        new WishCollection($invalidItems);
    }

    public function testAll()
    {
        $items = [
            $this->createMock(Wish::class),
            $this->createMock(Wish::class),
            $this->createMock(Wish::class)
        ];

        $collection = new WishCollection($items);

        $this->assertContainsOnlyInstancesOf(Wish::class, $collection->all());
        $this->assertCount(3, $collection->all());
    }

    public function testAdd()
    {
        $collection = new WishCollection();
        $this->assertCount(0, $collection->all());

        $collection->add($this->createMock(Wish::class));
        $this->assertCount(1, $collection->all());
        $this->assertContainsOnlyInstancesOf(Wish::class, $collection->all());
    }
}
