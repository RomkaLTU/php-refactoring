<?php

declare(strict_types=1);

namespace Tests\Unit\Processors;

use PHPUnit\Framework\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Services\OrderCalculatorService;
use App\Services\DiscountService;
use App\Services\DiscountRules\ThresholdDiscountRule;
use App\Services\DiscountRules\VipDiscountRule;
use App\Processors\OrderProcessor;

class OrderProcessorTest extends TestCase
{
    private function createDiscountService(): DiscountService
    {
        return new DiscountService([
            new ThresholdDiscountRule(),
            new VipDiscountRule(),
        ]);
    }

    public function testProcessOrdersSendsEmailForPending(): void
    {
        $order = new Order(
            'pending',
            new Customer('test@example.com', 'regular'),
            [new OrderItem(10, 2)]
        );
        $mockEmailService = $this->getMockBuilder(\App\Services\EmailService::class)
            ->onlyMethods(['send'])
            ->getMock();
        $mockEmailService->expects($this->once())
            ->method('send')
            ->with('test@example.com', $this->stringContains('Your order total: $20'));
        $orderProcessor = new OrderProcessor(
            new OrderCalculatorService($this->createDiscountService()),
            $mockEmailService
        );
        $orderProcessor->processOrders([$order]);
        $this->assertEquals('pending', $order->status);
        $this->assertEquals('regular', $order->customer->type);
    }

    public function testProcessOrdersSkipsCompleted(): void
    {
        $order = new Order(
            'completed',
            new Customer('test@example.com', 'regular'),
            [new OrderItem(10, 2)]
        );
        $mockEmailService = $this->getMockBuilder(\App\Services\EmailService::class)
            ->onlyMethods(['send'])
            ->getMock();
        $mockEmailService->expects($this->never())
            ->method('send');
        $orderProcessor = new OrderProcessor(
            new OrderCalculatorService($this->createDiscountService()),
            $mockEmailService
        );
        $orderProcessor->processOrders([$order]);
        $this->assertEquals('completed', $order->status);
    }
}
