<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Nombre de la tabla
    protected $table = 'reviews';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id',      // para relacionar con usuario (si quieres)
        'nombre',       // nombre del que hace el review
        'comentario',   // texto del comentario
        'producto_id',  // id del producto relacionado
        'puntuacion',        // Valor de la reseña
    ];

    // Si usas timestamps (created_at, updated_at)
    public $timestamps = true;

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // (Opcional) Relación con usuario si tienes user_id
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
