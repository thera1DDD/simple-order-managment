<?php

namespace App\Services\Contracts;

use App\Data\Movement\CreateMovementData;
use App\Data\Movement\MovementFilters;
use App\Models\Movement;

interface MovementServiceInterface
{
    public function createMovement(CreateMovementData $data): Movement;

    public function getMovements(MovementFilters $filters, int $perPage = 15);
}
