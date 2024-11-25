<?php

namespace App\Services;

use App\Models\Warehouse;

class WarehouseService
{
    /**
     * Получение всех складов.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllWarehouses()
    {
        return Warehouse::with('stocks.product')->get();
    }

    /**
     * Создание нового склада.
     *
     * @param array $data Данные для создания склада.
     * @return Warehouse Новый склад.
     */
    public function createWarehouse(array $data)
    {
        return Warehouse::create($data);
    }

    /**
     * Обновление информации о складе.
     *
     * @param int $id Идентификатор склада.
     * @param array $data Данные для обновления.
     * @return Warehouse Обновленный склад.
     */
    public function updateWarehouse($id, array $data)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update($data);
        return $warehouse;
    }

    /**
     * Удаление склада.
     *
     * @param int $id Идентификатор склада.
     * @return \Illuminate\Http\JsonResponse Ответ о результате удаления.
     */
    public function deleteWarehouse($id)
    {
        $warehouse = Warehouse::findOrFail($id);

        if ($warehouse->stocks()->exists()) {
            return response()->json(['error' => 'Warehouse cannot be deleted because it has stocks'], 422);
        }

        // Удаление склада
        $warehouse->delete();

        return response()->json(['message' => 'Warehouse deleted successfully']);
    }
}
