<?php

namespace App\Services\Movement;

use App\Data\Movement\CreateMovementData;
use App\Enums\MovementType;

class MovementStockUpdater
{
    public function handle(CreateMovementData $data): void
    {
        match ($data->type) {
            MovementType::OUTGOING => $this->decrease($data),
            MovementType::INCOMING => $this->increase($data),
        };
    }

    private function decrease(CreateMovementData $data): void
    {
        DB::table('stocks')
            ->where('warehouse_id', $data->warehouseId)
            ->where('product_id', $data->productId)
            ->where('stock', '>=', $data->quantity)
            ->decrement('stock', $data->quantity);
    }

    private function increase(CreateMovementData $data): void
    {
        DB::table('stocks')
            ->where('warehouse_id', $data->warehouseId)
            ->where('product_id', $data->productId)
            ->increment('stock', $data->quantity);
    }
}
