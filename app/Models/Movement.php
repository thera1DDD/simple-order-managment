<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'movements';

    /**
     * Атрибуты, которые можно массово назначить.
     *
     * @var array
     */
    protected $fillable = [
        'warehouse_id',
        'product_id',
        'type',
        'quantity',
        'created_at',
        'updated_at',
    ];

    /**
     * Типы движения (приход, расход).
     */
    public const TYPE_INCOMING = 'incoming';
    public const TYPE_OUTGOING = 'outgoing';

    /**
     * Связь с моделью склада.
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Связь с моделью продукта.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
