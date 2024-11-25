<?php

namespace App\Services;

use App\Models\Movement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MovementService
{
    /**
     * Создание записи о движении товара.
     *
     * @param array $data Данные для создания движения.
     *
     * @return Movement Созданная запись.
     */
    public function createMovement(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Создание движения
            $movement = Movement::create($data);

            // Обновление склада, если тип движения — расход
            if ($data['type'] === Movement::TYPE_OUTGOING) {
                DB::table('stocks')
                    ->where('warehouse_id', $data['warehouse_id'])
                    ->where('product_id', $data['product_id'])
                    ->where('stock', '>=', $data['quantity'])
                    ->decrement('stock', $data['quantity']);
            }

            // Обновление склада, если тип движения — приход
            if ($data['type'] === Movement::TYPE_INCOMING) {
                DB::table('stocks')
                    ->where('warehouse_id', $data['warehouse_id'])
                    ->where('product_id', $data['product_id'])
                    ->increment('stock', $data['quantity']);
            }

            return $movement;
        });
    }

    /**
     * Получение движений с поддержкой фильтров и пагинации.
     *
     * @param array $filters Фильтры для запроса.
     *
     * @return LengthAwarePaginator
     */
    public function getMovements(array $filters)
    {
        $query = Movement::query();

        if (!empty($filters['warehouse_id'])) {
            $query->where('warehouse_id', $filters['warehouse_id']);
        }

        if (!empty($filters['product_id'])) {
            $query->where('product_id', $filters['product_id']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }
}
