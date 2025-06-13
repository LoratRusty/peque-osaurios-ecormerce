<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'size_id',
        'cantidad',
        'precio_unitario',
    ];

    public function product()
    {
        return $this->belongsTo(Producto::class, 'product_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
