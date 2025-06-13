<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $table = 'payment_types';

    protected $fillable = [
        'nombre',
        'descripcion',
        'status',
    ];

    // Relación con pagos
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
