<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
        'user_id',
        'accion',
        'fecha',
    ];

    public $timestamps = false; // Ya que usas 'fecha', no 'created_at'

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
