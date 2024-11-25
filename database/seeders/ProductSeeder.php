<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::insert([
            ['name' => 'Товар 1', 'price' => 100],
            ['name' => 'Товар 2', 'price' => 200],
            ['name' => 'Товар 3', 'price' => 300],
        ]);
    }
}
