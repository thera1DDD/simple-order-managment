<?php

namespace App\Data\Movement;

use App\Enums\MovementType;

class CreateMovementData
{
    public function __construct(
        public int $warehouseId,
        public int $productId,
        public MovementType $type,
        public int $quantity
    ) {}
}
