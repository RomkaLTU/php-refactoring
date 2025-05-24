<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Services\OrderCalculatorService;
use App\Services\DiscountService;
use App\Services\DiscountRules\ThresholdDiscountRule;
use App\Services\DiscountRules\VipDiscountRule;

class OrderCalculatorServiceTest extends TestCase
{
    private function createDiscountService(): DiscountService
    {
        return new DiscountService([
            new ThresholdDiscountRule(),
            new VipDiscountRule(),
        ]);
    }

    public function testCalculateTotal(): void
    {
        $order = new Order(
            'pending',
            new Customer('test@example.com', 'regular'),
            [
                new OrderItem(10, 2),
                new OrderItem(5, 4)
            ]
        );
        $service = new OrderCalculatorService($this->createDiscountService());
        $this->assertEquals(10 * 2 + 5 * 4, $service->calculateTotal($order));
        $this->assertEquals('pending', $order->status);
        $this->assertEquals('test@example.com', $order->customer->email);
        $this->assertEquals(10, $order->items[0]->price);
    }

    public function testCalculateFinalTotalWithDiscount(): void
    {
        $order = new Order(
            'pending',
            new Customer('test@example.com', 'regular'),
            [
                new OrderItem(60, 2)
            ]
        );
        $service = new OrderCalculatorService($this->createDiscountService());

        $this->assertEquals(108, $service->calculateFinalTotal($order));
    }

    public function testCalculateFinalTotalWithVipDiscount(): void
    {
        $order = new Order(
            'pending',
            new Customer('test@example.com', 'vip'),
            [
                new OrderItem(60, 2)
            ]
        );
        $service = new OrderCalculatorService($this->createDiscountService());

        $this->assertEquals(97.2, $service->calculateFinalTotal($order));
    }
}
