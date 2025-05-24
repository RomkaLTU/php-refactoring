<?php

namespace App\Services;

use App\Models\Order;
use App\Services\DiscountRules\DiscountRuleInterface;

class DiscountService
{
    /** @param DiscountRuleInterface[] $rules */
    public function __construct(
        private readonly array $rules,
    ) {
    }

    public function getDiscount(Order $order, float $total): float
    {
        $discount = 0;

        foreach ($this->rules as $rule) {
            $discount += $rule->calculate($order, $total - $discount);
        }

        return $discount;
    }
}
