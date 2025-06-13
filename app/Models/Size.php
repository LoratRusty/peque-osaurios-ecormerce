<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory;

    protected $table = 'sizes';

    protected $fillable = [
        'etiqueta',
    ];

    public $timestamps = true;

    /**
     * Relación: una talla pertenece a muchos productos
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'product_size', 'size_id', 'product_id')
                    ->withPivot('stock')
                    ->withTimestamps();
    }
}
