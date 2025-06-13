<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'status',
    ];

    // Relación con los items del carrito
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }
}
