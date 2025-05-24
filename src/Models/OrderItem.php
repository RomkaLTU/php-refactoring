<?php

namespace App\Models;

class OrderItem
{
    public function __construct(
        public readonly float $price,
        public readonly int $quantity,
    ) {
    }
}
