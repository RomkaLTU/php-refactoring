<?php

namespace App\Services\DiscountRules;

use App\Models\Order;

interface DiscountRuleInterface
{
    public function calculate(Order $order, float $total): float;
}
