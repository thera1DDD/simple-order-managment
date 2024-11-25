<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer', 'warehouse_id', 'status', 'completed_at'];
    public $timestamps = false; // Отключение временных меток
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
