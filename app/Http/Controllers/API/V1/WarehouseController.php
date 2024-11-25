<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWarehouseRequest;
use App\Services\WarehouseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

/**
 * Контроллер для работы со складами.
 */
class WarehouseController extends Controller
{
    /**
     * Сервис для работы со складами.
     *
     * @var WarehouseService
     */
    private WarehouseService $warehouseService;

    /**
     * Конструктор контроллера.
     *
     * @param WarehouseService $warehouseService Сервис для работы со складами.
     */
    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    /**
     * Получение списка всех складов.
     *
     * @return Builder[]|Collection Список складов.
     */
    public function index(): Collection|array
    {
        return $this->warehouseService->getAllWarehouses();
    }

    /**
     * Создание нового склада.
     *
     * @param StoreWarehouseRequest $request Данные для создания склада.
     * @return JsonResponse Ответ с данными о новом складе.
     */
    public function store(StoreWarehouseRequest $request): JsonResponse
    {
        $data = $request->validated();

        $warehouse = $this->warehouseService->createWarehouse($data);

        return response()->json($warehouse, 201);
    }

    /**
     * Обновление склада.
     *
     * @param StoreWarehouseRequest $request Данные для обновления склада.
     * @param int $id Идентификатор склада.
     * @return JsonResponse Ответ с обновленными данными склада.
     */
    public function update(StoreWarehouseRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $warehouse = $this->warehouseService->updateWarehouse($id, $data);

        return response()->json($warehouse);
    }

    /**
     * Удаление склада.
     *
     * @param int $id Идентификатор склада.
     * @return JsonResponse Ответ о результате удаления.
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->warehouseService->deleteWarehouse($id);
    }
}
