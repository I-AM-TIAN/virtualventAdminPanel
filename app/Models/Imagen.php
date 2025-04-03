<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    //
    protected $table = 'imagenes';
    protected $fillable = ['producto_id', 'imagen'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
