<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id',
        'product_id',
        'cantidad',
        'precio_unitario',
        'size_id',
    ];

    // Relación con el carrito
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    // Relación con el producto
    public function product(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'product_id');
    }

    // Relación con la talla (size)
    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
}
