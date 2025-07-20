<?php

namespace App\Repositories\Contracts;

use App\Data\Movement\CreateMovementData;
use App\Data\Movement\MovementFilters;
use App\Models\Movement;

interface MovementRepositoryInterface
{
    public function create(CreateMovementData $data): Movement;

    public function paginateWithFilters(MovementFilters $filters, int $perPage = 15);
}
