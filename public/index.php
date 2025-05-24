<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Services\OrderCalculatorService;
use App\Services\DiscountService;
use App\Services\DiscountRules\ThresholdDiscountRule;
use App\Services\DiscountRules\VipDiscountRule;
use App\Services\EmailService;
use App\Processors\OrderProcessor;

$orders = [
    new Order(
        'pending',
        new Customer('customer1@example.com', 'vip'),
        [
            new OrderItem(50, 2),
            new OrderItem(30, 1)
        ]
    ),
    new Order(
        'completed',
        new Customer('customer2@example.com', 'regular'),
        [
            new OrderItem(20, 3)
        ]
    )
];

$discountService = new DiscountService([
    new ThresholdDiscountRule(),
    new VipDiscountRule(),
]);
$orderCalculatorService = new OrderCalculatorService($discountService);
$emailService = new EmailService();
$orderProcessor = new OrderProcessor($orderCalculatorService, $emailService);

Flight::route('/', function () use ($orderProcessor, $orders) {
    ob_start();
    $orderProcessor->processOrders($orders);
    $output = ob_get_clean();
    echo nl2br($output);
});

Flight::start();
