<?php

namespace App\Services\Movement;

use App\Data\Movement\CreateMovementData;
use App\Data\Movement\MovementFilters;
use App\Models\Movement;
use App\Repositories\Contracts\MovementRepositoryInterface;
use App\Services\Contracts\MovementServiceInterface;
use Illuminate\Support\Facades\DB;

class MovementService implements MovementServiceInterface
{
    public function __construct(
        private MovementRepositoryInterface $repository,
        private MovementStockUpdater $stockUpdater
    ) {}

    public function createMovement(CreateMovementData $data): Movement
    {
        return DB::transaction(function () use ($data) {
            $movement = $this->repository->create($data);
            $this->stockUpdater->handle($data);
            return $movement;
        });
    }

    public function getMovements(MovementFilters $filters, int $perPage = 15)
    {
        return $this->repository->paginateWithFilters($filters, $perPage);
    }
}
