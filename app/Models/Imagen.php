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

    protected static function booted(): void
    {
        static::creating(function (self $imagen) {
            if (empty($imagen->uuid)) {
                $imagen->uuid = \Illuminate\Support\Str::uuid()->toString();
            }
        });
    }
}
