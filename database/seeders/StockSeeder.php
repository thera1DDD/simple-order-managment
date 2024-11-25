<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;

class StockSeeder extends Seeder
{
    public function run()
    {
        Stock::insert([
            ['warehouse_id' => 1, 'product_id' => 1, 'stock' => 50],
            ['warehouse_id' => 1, 'product_id' => 2, 'stock' => 30],
            ['warehouse_id' => 2, 'product_id' => 3, 'stock' => 20],
        ]);
    }
}
