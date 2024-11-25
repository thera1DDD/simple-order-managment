<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

/**
 * Контроллер для работы с заказами.
 */
class OrderController extends Controller
{
    /**
     * Сервис для работы с заказами.
     *
     * @var OrderService
     */
    private OrderService $orderService;

    /**
     * Конструктор контроллера.
     *
     * @param OrderService $orderService Сервис для работы с заказами.
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Получение списка заказов с поддержкой фильтров и пагинации.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Список заказов.
     */
    public function index()
    {
        // Извлекаем параметры запроса и передаем их в сервис для обработки.
        return $this->orderService->getAllOrders(request()->all());
    }

    /**
     * Создание нового заказа.
     *
     * @param StoreOrderRequest $request Запрос с валидированными данными для создания заказа.
     * @return JsonResponse Созданный заказ или сообщение об ошибке.
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        // Передаем валидированные данные из запроса в сервис для создания заказа.
        return $this->orderService->createOrder($request->validated());
    }

    /**
     * Обновление данных существующего заказа.
     *
     * @param UpdateOrderRequest $request Запрос с валидированными данными для обновления заказа.
     * @param int $id Идентификатор заказа.
     * @return JsonResponse Обновленный заказ или сообщение об ошибке.
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        // Передаем идентификатор заказа и валидированные данные в сервис для обновления заказа.
        return $this->orderService->updateOrder($id, $request->validated());
    }

    /**
     * Завершение заказа.
     *
     * @param int $id Идентификатор заказа.
     * @return JsonResponse Статус завершения или сообщение об ошибке.
     */
    public function complete($id)
    {
        // Вызываем сервис для завершения заказа.
        return $this->orderService->completeOrder($id);
    }

    /**
     * Отмена заказа.
     *
     * @param int $id Идентификатор заказа.
     * @return JsonResponse Статус отмены или сообщение об ошибке.
     */
    public function cancel($id)
    {
        // Вызываем сервис для отмены заказа.
        return $this->orderService->cancelOrder($id);
    }

    /**
     * Возобновление отмененного заказа.
     *
     * @param int $id Идентификатор заказа.
     * @return JsonResponse Статус возобновления или сообщение об ошибке.
     */
    public function resume($id)
    {
        // Вызываем сервис для возобновления заказа.
        return $this->orderService->resumeOrder($id);
    }
}
