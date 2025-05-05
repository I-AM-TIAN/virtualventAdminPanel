<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    //
    protected $table = 'direcciones';

    protected $fillable = ['corporativo_id', 'pais_id', 'departamento_id', 'ciudad_id', 'detalle'];

    public function corporativo()
    {
        return $this->belongsTo(Corporativo::class);
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }

    protected static function booted(): void
    {
        static::creating(function (self $direccion) {
            if (empty($direccion->uuid)) {
                $direccion->uuid = \Illuminate\Support\Str::uuid()->toString();
            }
        });
    }
}
