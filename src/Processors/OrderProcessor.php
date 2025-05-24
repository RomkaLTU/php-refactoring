<?php

namespace App\Processors;

use App\Models\Order;
use App\Services\OrderCalculatorService;
use App\Services\EmailService;

class OrderProcessor
{
    public function __construct(
        private readonly OrderCalculatorService $orderCalculatorService,
        private readonly EmailService $emailService,
    ) {
    }

    /**
     * @param Order[] $orders
     */
    public function processOrders(array $orders): void
    {
        foreach ($orders as $order) {
            if ($order->status === 'pending') {
                $finalTotal = $this->orderCalculatorService->calculateFinalTotal($order);
                $this->emailService->send(
                    $order->customer->email,
                    "Your order total: $" . $finalTotal,
                );
            }
        }
    }
}
