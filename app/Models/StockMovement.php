<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property int $warehouse_id
 * @property int $change
 * @property \Carbon\Carbon $created_at
 */
class StockMovement extends Model
{
    protected $fillable = ['product_id', 'warehouse_id', 'change', 'created_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
