<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function getAllOrders(array $filters)
    {
        return Order::with('items.product')
            ->when($filters['status'] ?? null, fn($q) => $q->where('status', $filters['status']))
            ->when($filters['customer'] ?? null, fn($q) => $q->where('customer', 'like', '%' . $filters['customer'] . '%'))
            ->paginate($filters['per_page'] ?? 10);
    }

    public function createOrder(array $data)
    {
        DB::transaction(function () use ($data) {
            $order = Order::create([
                'customer' => $data['customer'],
                'warehouse_id' => $data['warehouse_id'],
                'status' => 'active',
            ]);

            foreach ($data['items'] as $item) {
                Stock::where('warehouse_id', $data['warehouse_id'])
                    ->where('product_id', $item['product_id'])
                    ->where('stock', '>=', $item['count'])
                    ->decrement('stock', $item['count']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'count' => $item['count'],
                ]);
            }
        });

        return response()->json(['message' => 'Order created successfully'], 201);
    }

    public function updateOrder($id, array $data)
    {
        $order = Order::findOrFail($id);

        DB::transaction(function () use ($order, $data) {
            $order->update(['customer' => $data['customer']]);
            $order->items()->delete();

            foreach ($data['items'] as $item) {
                $order->items()->create($item);
            }
        });

        return response()->json(['message' => 'Order updated successfully']);
    }

    public function completeOrder($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'active') {
            return response()->json(['error' => 'Order cannot be completed'], 422);
        }

        $order->update(['status' => 'completed','completed_at' => now()]);

        return response()->json(['message' => 'Order completed successfully']);
    }

    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'active') {
            return response()->json(['error' => 'Order cannot be canceled'], 422);
        }

        $order->update(['status' => 'canceled']);
        return response()->json(['message' => 'Order canceled successfully']);
    }

    public function resumeOrder($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'canceled') {
            return response()->json(['error' => 'Only canceled orders can be resumed'], 422);
        }

        foreach ($order->items as $item) {
            $stock = Stock::where('product_id', $item->product_id)
                ->where('warehouse_id', $order->warehouse_id)
                ->first();

            if ($stock->stock < $item->count) {
                return response()->json(['error' => 'Insufficient stock to resume order'], 422);
            }
        }

        $order->update(['status' => 'active']);
        return response()->json(['message' => 'Order resumed successfully']);
    }
}
