<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public $timestamps = true;

    /**
     * Relación: una categoría tiene muchos productos
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}
