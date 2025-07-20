<?php

namespace App\Repositories;

use App\Data\Movement\CreateMovementData;
use App\Data\Movement\MovementFilters;
use App\Models\Movement;
use App\Repositories\Contracts\MovementRepositoryInterface;

class MovementRepository implements MovementRepositoryInterface
{
    public function create(CreateMovementData $data): Movement
    {
        return Movement::create([
            'warehouse_id' => $data->warehouseId,
            'product_id' => $data->productId,
            'type' => $data->type->value,
            'quantity' => $data->quantity,
        ]);
    }

    public function paginateWithFilters(MovementFilters $filters, int $perPage = 15)
    {
        return Movement::query()
            ->when($filters->warehouseId, fn($q) => $q->where('warehouse_id', $filters->warehouseId))
            ->when($filters->productId, fn($q) => $q->where('product_id', $filters->productId))
            ->when($filters->startDate, fn($q) => $q->whereDate('created_at', '>=', $filters->startDate))
            ->when($filters->endDate, fn($q) => $q->whereDate('created_at', '<=', $filters->endDate))
            ->paginate($perPage);
    }
}
