<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'direccion_envio',
        'pago_id',
        'fecha',
    ];

    // Un pedido pertenece a un usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Un pedido tiene muchos items
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // relación con el pago
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'pago_id');
    }
    
}
