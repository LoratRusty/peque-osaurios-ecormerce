<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'color',
        'categoria_id',
        'imagen',
        'status',
    ];

    public $timestamps = true;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size', 'product_id', 'size_id')
            ->withPivot('stock');
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id');
    }

    // Accesor para stock total sumando stock de todas las tallas
    public function getStockTotalAttribute()
    {
        return $this->sizes->sum(function ($size) {
            return $size->pivot->stock;
        });
    }

    // Accesor para stock por talla en forma de array ['etiqueta' => stock, ...]
    public function getStockPorTallaAttribute()
    {
        return $this->sizes->mapWithKeys(function ($size) {
            return [strtolower($size->etiqueta) => $size->pivot->stock];
        })->toArray();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'producto_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
