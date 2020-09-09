<?php

namespace WishApp\Tests\Service\Wish;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use WishApp\Model\Exception\ModelNotFoundException;
use WishApp\Model\Wish\ValueObject\Amount;
use WishApp\Model\Wish\ValueObject\Description;
use WishApp\Model\Wish\ValueObject\Title;
use WishApp\Model\Wish\Wish;
use WishApp\Model\Wish\WishCollection;
use WishApp\Repository\Contracts\WishRepositoryInterface;
use WishApp\Service\Wish\Contracts\WishServiceInterface;
use WishApp\Service\Wish\DTO\CreateWishDTO;
use WishApp\Service\Wish\DTO\UpdateWishDTO;
use WishApp\Service\Wish\Exception\PermissionDeniedException;
use WishApp\Service\Wish\WishService;

class WishServiceTest extends TestCase
{
    private WishRepositoryInterface $wishRepository;

    protected function setUp(): void
    {
        $this->wishRepository = $this->createMock(WishRepositoryInterface::class);

        parent::setUp();
    }

    public function testCreation()
    {
        $service = new WishService($this->wishRepository);

        $this->assertInstanceOf(WishServiceInterface::class, $service);
    }

    public function testCreate()
    {
        $dto = new CreateWishDTO(
            Uuid::uuid4(),
            Title::fromString('Title'),
            Money::USD(10000),
            Description::fromString('Description')
        );

        $service = new WishService($this->wishRepository);
        $wish = $service->create($dto);

        $this->assertInstanceOf(Wish::class, $wish);
    }

    public function testUpdate()
    {
        $wishId = Uuid::uuid4();
        $userId = Uuid::uuid4();
        $wish = new Wish(
            $wishId,
            $userId,
            $this->createMock(Title::class),
            $this->createMock(Amount::class)
        );
        $dto = new UpdateWishDTO();

        $this
            ->wishRepository
            ->method('findOneById')
            ->with($wishId)
            ->willReturn($wish);

        $service = new WishService($this->wishRepository);
        $updatedWish = $service->update($wishId, $userId, $dto);

        $this->assertInstanceOf(Wish::class, $updatedWish);
    }

    public function testUpdateThrowsIfWishNotFound()
    {
        $wishId = Uuid::uuid4();
        $dto = new UpdateWishDTO();

        $this
            ->wishRepository
            ->method('findOneById')
            ->with($wishId)
            ->willReturn(null);

        $service = new WishService($this->wishRepository);

        $this->expectException(ModelNotFoundException::class);

        $service->update($wishId, Uuid::uuid4(), $dto);
    }

    public function testUpdateThrowsIfUserNotOwnerOfWish()
    {
        $wishId = Uuid::uuid4();
        $wish = new Wish(
            $wishId,
            Uuid::uuid4(),
            $this->createMock(Title::class),
            $this->createMock(Amount::class)
        );
        $dto = new UpdateWishDTO();

        $this
            ->wishRepository
            ->method('findOneById')
            ->with($wishId)
            ->willReturn($wish);

        $service = new WishService($this->wishRepository);

        $this->expectException(PermissionDeniedException::class);

        $service->update($wishId, Uuid::uuid4(), $dto);
    }

    public function testChangeGoalAmount()
    {
        $wishId = Uuid::uuid4();
        $userId = Uuid::uuid4();
        $wishAmount = Money::USD(1000);
        $wish = new Wish(
            $wishId,
            $userId,
            Title::fromString('Title'),
            new Amount($wishAmount)
        );

        $this
            ->wishRepository
            ->method('findOneById')
            ->with($wishId)
            ->willReturn($wish);

        $service = new WishService($this->wishRepository);
        $updatedWish = $service->changeGoalAmount($wishId, $userId, Money::USD(5000));

        $this->assertInstanceOf(Wish::class, $updatedWish);
        $this->assertEquals(
            5000,
            $updatedWish->getGoalAmount()->getAmount()
        );
    }

    public function testChangeGoalAmountThrowsIfWishNotFound()
    {
        $wishId = Uuid::uuid4();

        $this
            ->wishRepository
            ->method('findOneById')
            ->with($wishId)
            ->willReturn(null);

        $service = new WishService($this->wishRepository);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Wish not found');

        $service->changeGoalAmount($wishId, Uuid::uuid4(), Money::USD(5000));
    }

    public function testChangeGoalAmountThrowsIfUserNotOwnerOfWish()
    {
        $wishId = Uuid::uuid4();
        $wish = new Wish(
            $wishId,
            Uuid::uuid4(),
            Title::fromString('Title'),
            new Amount(Money::USD(1000))
        );

        $this
            ->wishRepository
            ->method('findOneById')
            ->with($wishId)
            ->willReturn($wish);

        $service = new WishService($this->wishRepository);

        $this->expectException(PermissionDeniedException::class);
        $service->changeGoalAmount($wishId, Uuid::uuid4(), Money::USD(5000));
    }

    public function testChargeDepositAmount()
    {
        $wishId = Uuid::uuid4();
        $userId = Uuid::uuid4();
        $wishAmount = Money::USD(1000);
        $wish = new Wish(
            $wishId,
            $userId,
            Title::fromString('Title'),
            new Amount($wishAmount)
        );

        $this->assertEquals(0, $wish->getDepositedAmount()->getAmount());

        $this
            ->wishRepository
            ->method('findOneById')
            ->with($wishId)
            ->willReturn($wish);

        $service = new WishService($this->wishRepository);
        $updatedWish = $service->chargeDepositAmount($wishId, $userId, Money::USD(5000));

        $this->assertInstanceOf(Wish::class, $updatedWish);
        $this->assertEquals(
            5000,
            $updatedWish->getDepositedAmount()->getAmount()
        );
    }

    public function testChargeDepositAmountThrowsIfWishNotFound()
    {
        $wishId = Uuid::uuid4();
        $this
            ->wishRepository
            ->method('findOneById')
            ->with($wishId)
            ->willReturn(null);

        $service = new WishService($this->wishRepository);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Wish not found');

        $service->chargeDepositAmount($wishId, Uuid::uuid4(), Money::USD(5000));
    }

    public function testChargeDepositAmountThrowsIfUserNotOwnerOfWish()
    {
        $wishId = Uuid::uuid4();
        $wishAmount = Money::USD(1000);
        $wish = new Wish(
            $wishId,
            Uuid::uuid4(),
            Title::fromString('Title'),
            new Amount($wishAmount)
        );

        $this
            ->wishRepository
            ->method('findOneById')
            ->with($wishId)
            ->willReturn($wish);

        $service = new WishService($this->wishRepository);

        $this->expectException(PermissionDeniedException::class);

        $service->chargeDepositAmount($wishId, Uuid::uuid4(), Money::USD(5000));
    }

    public function testGetAllByUser()
    {
        $userId = Uuid::uuid4();

        $this
            ->wishRepository
            ->method('findAllByUserId')
            ->with($userId)
            ->willReturn(new WishCollection());

        $service = new WishService($this->wishRepository);
        $collection = $service->getAllByUser($userId);

        $this->assertInstanceOf(WishCollection::class, $collection);
    }

    public function testDelete()
    {
        $wishId = Uuid::uuid4();
        $userId = Uuid::uuid4();
        $wish = new Wish(
            $wishId,
            $userId,
            Title::fromString('Title'),
            new Amount(Money::USD(1000))
        );

        $this
            ->wishRepository
            ->method('findOneById')
            ->with($wishId)
            ->willReturn($wish);

        $service = new WishService($this->wishRepository);

        $this->assertNull($service->delete($wishId, $userId));
    }

    public function testDeleteThrowsWhenWishNotFound()
    {
        $wishId = Uuid::uuid4();
        $this->wishRepository->method('findOneById')->with($wishId)->willReturn(null);

        $service = new WishService($this->wishRepository);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Wish not found');

        $service->delete($wishId, Uuid::uuid4());
    }

    public function testDeleteThrowsIfUserNotOwnerOfWish()
    {
        $wishId = Uuid::uuid4();
        $wish = new Wish(
            $wishId,
            Uuid::uuid4(),
            Title::fromString('Title'),
            new Amount(Money::USD(1000))
        );

        $this
            ->wishRepository
            ->method('findOneById')
            ->with($wishId)
            ->willReturn($wish);

        $service = new WishService($this->wishRepository);

        $this->expectException(PermissionDeniedException::class);

        $service->delete($wishId, Uuid::uuid4());
    }
}
