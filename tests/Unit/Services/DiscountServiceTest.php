<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Services\DiscountService;
use App\Services\DiscountRules\ThresholdDiscountRule;
use App\Services\DiscountRules\VipDiscountRule;

class DiscountServiceTest extends TestCase
{
    private function createService(): DiscountService
    {
        return new DiscountService([
            new ThresholdDiscountRule(),
            new VipDiscountRule(),
        ]);
    }

    public function testNoDiscountBelowThreshold(): void
    {
        $order = new Order(
            'pending',
            new Customer('test@example.com', 'regular'),
            [
                new OrderItem(10, 2)
            ]
        );
        $service = $this->createService();
        $this->assertEquals(0, $service->getDiscount($order, 20));
        $this->assertEquals('regular', $order->customer->type);
    }

    public function testDiscountAboveThreshold(): void
    {
        $order = new Order(
            'pending',
            new Customer('test@example.com', 'regular'),
            [
                new OrderItem(60, 2)
            ]
        );
        $service = $this->createService();

        $this->assertEquals(12, $service->getDiscount($order, 120));
    }

    public function testVipDiscount(): void
    {
        $order = new Order(
            'pending',
            new Customer('test@example.com', 'vip'),
            [
                new OrderItem(60, 2)
            ]
        );
        $service = $this->createService();

        $this->assertEquals(22.8, $service->getDiscount($order, 120));
    }
}
