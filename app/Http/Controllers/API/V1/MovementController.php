<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovementRequest;
use App\Services\MovementService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Контроллер для работы с движениями товаров.
 */
class MovementController extends Controller
{
    /**
     * Сервис для работы с движениями товаров.
     *
     * @var MovementService
     */
    private MovementService $movementService;

    /**
     * Конструктор контроллера.
     *
     * @param MovementService $movementService Сервис для работы с движениями товаров.
     */
    public function __construct(MovementService $movementService)
    {
        $this->movementService = $movementService;
    }

    /**
     * Получение истории движений товаров.
     *
     * @param Request $request HTTP-запрос, содержащий фильтры.
     *
     * @return LengthAwarePaginator История движений товаров с поддержкой фильтров и пагинации.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['warehouse_id', 'product_id', 'start_date', 'end_date', 'per_page']);

        return $this->movementService->getMovements($filters);
    }

    /**
     * Создание записи о движении товара.
     *
     * @param Request $request HTTP-запрос, содержащий данные о движении.
     *
     * @return JsonResponse Ответ с подтверждением или ошибкой.
     */
    public function store(StoreMovementRequest $request): JsonResponse
    {
        // Валидация входных данных
        $validatedData = $request->validated();

        // Создание записи о движении через сервис
        $movement = $this->movementService->createMovement($validatedData);

        return response()->json([
            'message' => 'Movement created successfully',
            'data' => $movement,
        ], 201);
    }
}
