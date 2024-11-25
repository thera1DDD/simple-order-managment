<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovementRequest extends FormRequest
{
    public function rules()
    {
        return [
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:incoming,outgoing',
            'quantity' => 'required|integer|min:1',
        ];
    }
}
