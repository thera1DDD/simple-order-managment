<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Stock;

class ProductService
{
    public function getProductsWithStocks()
    {
        return Product::with(['stocks.warehouse'])
            ->get()
            ->map(function ($product) {
                $totalStock = $product->stocks->sum('stock');
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'total_stock' => $totalStock,
                    'stocks' => $product->stocks,
                ];
            });
    }
}
