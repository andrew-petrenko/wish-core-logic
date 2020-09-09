<?php

namespace WishApp\Tests\Model\Wish\ValueObject;

use Money\Money;
use PHPUnit\Framework\TestCase;
use WishApp\Model\Wish\ValueObject\Amount;

class AmountTest extends TestCase
{
    public function testCreation()
    {
        $amount = new Amount(Money::USD(10000), Money::USD(5000));

        $this->assertInstanceOf(Amount::class, $amount);
    }

    public function testGetGoalAmount()
    {
        $amount = new Amount(Money::USD(10000));

        $this->assertInstanceOf(Money::class, $amount->getGoalAmount());
        $this->assertEquals(
            10000,
            $amount->getGoalAmount()->getAmount()
        );
    }

    public function testGetDepositedAmount()
    {
        $amount = new Amount(Money::USD(5000), Money::USD(1000));

        $this->assertInstanceOf(Money::class, $amount->getDepositedAmount());
        $this->assertEquals(
            1000,
            $amount->getDepositedAmount()->getAmount()
        );
    }

    public function testGetDepositedAmountIfItsNull()
    {
        $amount = new Amount(Money::USD(5000));

        $this->assertInstanceOf(Money::class, $amount->getDepositedAmount());
        $this->assertEquals(
            0,
            $amount->getDepositedAmount()->getAmount()
        );
    }

    public function testSetGoalAmount()
    {
        $amount = new Amount(Money::USD(5000));
        $amount->setGoalAmount(Money::USD(9000));

        $this->assertEquals(
            9000,
            $amount->getGoalAmount()->getAmount()
        );
    }

    public function testChargeDeposit()
    {
        $amount = new Amount(Money::USD(5000), Money::USD(2000));
        $amount->chargeDeposit(Money::USD(1000));

        $this->assertEquals(
            3000,
            $amount->getDepositedAmount()->getAmount()
        );
    }
}
