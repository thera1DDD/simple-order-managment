<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run()
    {
        Warehouse::insert([
            ['name' => 'Склад А',],
            ['name' => 'Склад Б'],
        ]);
    }
}
