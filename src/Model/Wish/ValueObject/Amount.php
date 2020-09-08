<?php

namespace WishApp\Model\Wish\ValueObject;

use Money\Currency;
use Money\Money;

class Amount
{
    private Money $goalAmount;
    private ?Money $depositedAmount;

    public function __construct(Money $goalAmount, ?Money $depositedAmount = null)
    {
        $this->goalAmount = $goalAmount;
        $this->depositedAmount = $depositedAmount ?? new Money(0, new Currency('USD'));
    }

    public function getGoalAmount(): Money
    {
        return $this->goalAmount;
    }

    public function getDepositedAmount(): Money
    {
        return $this->depositedAmount;
    }

    public function setGoalAmount(Money $money): void
    {
        $this->goalAmount = $money;
    }

    public function chargeDeposit(Money $money): void
    {
        $this->depositedAmount = $this->depositedAmount->add($money);
    }
}
