<?php

namespace App\Models;

class Order
{
    /**
     * @param OrderItem[] $items
     */
    public function __construct(
        public readonly string $status,
        public readonly Customer $customer,
        public readonly array $items,
    ) {
    }
}
