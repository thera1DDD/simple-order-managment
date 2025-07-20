<?php


namespace App\Http\Controllers\API\V1;

use App\Data\Movement\CreateMovementData;
use App\Data\Movement\MovementFilters;
use App\Enums\MovementType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovementRequest;
use App\Services\Contracts\MovementServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    public function __construct(private MovementServiceInterface $movementService) {}

    public function index(Request $request): JsonResponse
    {
        $filters = new MovementFilters(
            warehouseId: $request->integer('warehouse_id'),
            productId: $request->integer('product_id'),
            startDate: $request->input('start_date'),
            endDate: $request->input('end_date'),
        );

        $perPage = $request->integer('per_page', 15);

        return response()->json($this->movementService->getMovements($filters, $perPage));
    }

    public function store(StoreMovementRequest $request): JsonResponse
    {
        $data = new CreateMovementData(
            warehouseId: $request->input('warehouse_id'),
            productId: $request->input('product_id'),
            type: MovementType::from($request->input('type')),
            quantity: $request->input('quantity')
        );

        $movement = $this->movementService->createMovement($data);

        return response()->json([
            'message' => 'Movement created successfully',
            'data' => $movement,
        ], 201);
    }
}
