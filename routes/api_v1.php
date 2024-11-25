<?php

use App\Http\Controllers\API\V1\MovementController;
use App\Http\Controllers\API\V1\OrderController;
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\API\V1\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('warehouses')->group(function () {
    Route::get('/', [WarehouseController::class, 'index']); // Получение списка складов
    Route::post('/', [WarehouseController::class, 'store']); // Создание нового склада
    Route::put('/{warehouse}', [WarehouseController::class, 'update']); // Обновление информации о складе
    Route::delete('/{warehouse}', [WarehouseController::class, 'destroy']); // Удаление склада
});

/**
 * Группа маршрутов для товаров
 *
 * Функционал:
 * - Просматривать список товаров
 * - Учитывать остатки по каждому складу
 */
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']); // Получение списка товаров с остатками
});

/**
 * Группа маршрутов для заказов
 *
 * Функционал:
 * - Получать список заказов с фильтрацией
 * - Создавать новые заказы
 * - Обновлять существующие заказы
 * - Управлять статусами заказов (завершение, отмена, возобновление)
 */
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::put('/{order}', [OrderController::class, 'update']);
    Route::post('/{order}/complete', [OrderController::class, 'complete']);
    Route::post('/{order}/cancel', [OrderController::class, 'cancel']);
    Route::post('/{order}/resume', [OrderController::class, 'resume']);
});

/**
 * Группа маршрутов для истории движений товаров
 *
 * Функционал:
 * - Просматривать историю изменений остатков
 * - Добавлять движения товаров
 */
Route::prefix('movements')->group(function () {
    Route::get('/', [MovementController::class, 'index']);
    Route::post('/', [MovementController::class, 'store']);
});
