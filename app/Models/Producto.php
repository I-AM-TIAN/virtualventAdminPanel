<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
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
