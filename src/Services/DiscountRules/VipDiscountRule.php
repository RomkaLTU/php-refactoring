<?php

namespace App\Services\DiscountRules;

use App\Models\Order;
use App\Config\Constants;

class VipDiscountRule implements DiscountRuleInterface
{
    public function calculate(Order $order, float $total): float
    {
        return $order->customer->type === 'vip' ? $total * Constants::VIP_DISCOUNT_RATE : 0;
    }
}
