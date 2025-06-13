<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $table = 'product_size';

    protected $fillable = [
        'product_id',
        'size_id',
        'stock'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'product_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
}
