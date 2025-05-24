<?php

namespace App\Models;

class Customer
{
    public function __construct(
        public readonly string $email,
        public readonly string $type,
    ) {
    }
}
