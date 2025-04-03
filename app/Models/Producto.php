<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    //
    protected $table = 'productos';
    protected $fillable = ['nombre', 'descripcion', 'stock', 'precio', 'categoria_id', 'corporativo_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function corporativo()
    {
        return $this->belongsTo(Corporativo::class);
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }   
}
