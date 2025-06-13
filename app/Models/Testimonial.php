<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory;

    // Nombre de la tabla 
    protected $table = 'reviews';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'comentario',
        'imagen',
    ];

    // Casts para formato de fecha si lo necesitas
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
