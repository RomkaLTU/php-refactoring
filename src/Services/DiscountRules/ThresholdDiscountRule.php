<?php

namespace App\Services\DiscountRules;

use App\Models\Order;
use App\Config\Constants;

class ThresholdDiscountRule implements DiscountRuleInterface
{
    public function calculate(Order $order, float $total): float
    {
        return $total > Constants::DISCOUNT_THRESHOLD ? $total * Constants::DISCOUNT_RATE : 0;
    }
}
