<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeedTestReferences extends Command
{
    protected $signature = 'seed:test-references';

    protected $description = 'Наполняет справочники товаров, складов и остатков тестовыми данными.';

    public function handle(): int
    {
        DB::transaction(function () {
            $this->info('Очищаем текущие данные...');
            DB::table('stocks')->truncate();
            Product::truncate();
            Warehouse::truncate();

            $this->info('Создаём склады...');
            $warehouses = Warehouse::factory()->count(5)->create();

            $this->info('Создаём товары...');
            $products = Product::factory()->count(20)->create();

            $this->info('Создаём остатки...');
            foreach ($warehouses as $warehouse) {
                foreach ($products as $product) {
                    DB::table('stocks')->insert([
                        'warehouse_id' => $warehouse->id,
                        'product_id' => $product->id,
                        'stock' => rand(0, 100),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        $this->info('Тестовые данные успешно созданы.');

        return Command::SUCCESS;
    }
}
