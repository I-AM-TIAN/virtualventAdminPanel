<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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

    /**
     * Boot method to generate UUID when creating a new model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $producto) {
            if (empty($producto->uuid)) {
                $producto->uuid = Str::uuid()->toString();
            }
        });
    }
}
