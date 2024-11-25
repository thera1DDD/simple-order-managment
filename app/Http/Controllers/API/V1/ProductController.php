<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\ProductService;

/**
 * Контроллер для работы с товарами.
 */
class ProductController extends Controller
{
    /**
     * Сервис для работы с товарами.
     *
     * @var ProductService
     */
    private ProductService $productService;

    /**
     * Конструктор контроллера.
     *
     * @param ProductService $productService Сервис для работы с товарами.
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Получение списка товаров с остатками на складах.
     *
     * @return \Illuminate\Http\JsonResponse Список товаров с их остатками.
     */
    public function index()
    {
        // Используем сервис для получения данных о товарах и их остатках.
        return $this->productService->getProductsWithStocks();
    }
}
