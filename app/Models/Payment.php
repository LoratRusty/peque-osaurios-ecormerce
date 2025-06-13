<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'payment_type_id',
        'monto',
        'estado',
        'referencia',
        'fecha',
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el tipo de pago
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    // Relación con el pedido si el campo existe en orders (pago_id)
    public function order()
    {
        return $this->hasOne(Order::class, 'pago_id');
    }
    
}
