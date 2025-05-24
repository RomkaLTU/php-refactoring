<?php

namespace App\Services;

use App\Models\Order;

class OrderCalculatorService
{
    public function __construct(
        private readonly DiscountService $discountService,
    ) {
    }

    public function calculateTotal(Order $order): float
    {
        $total = 0;

        foreach ($order->items as $item) {
            $total += $item->price * $item->quantity;
        }

        return $total;
    }

    public function calculateFinalTotal(Order $order): float
    {
        $total = $this->calculateTotal($order);
        $discount = $this->discountService->getDiscount($order, $total);
        $finalTotal = $total - $discount;

        return $finalTotal;
    }
}
