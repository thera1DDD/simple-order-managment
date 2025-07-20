<?php

namespace App\Data\Movement;

class MovementFilters
{
    public function __construct(
        public ?int $warehouseId = null,
        public ?int $productId = null,
        public ?string $startDate = null,
        public ?string $endDate = null
    ) {}
}
