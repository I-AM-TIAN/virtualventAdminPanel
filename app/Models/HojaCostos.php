<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HojaCostos extends Model
{
    protected $fillable = [
        'nombre',
        'materiales',
        'labores',
        'indirectos',
        'cantidad',
        'margen',
        'costo_total',
        'costo_unitario',
        'corporativo_id',
    ];

    protected $casts = [
        'materiales' => 'array',
        'labores' => 'array',
        'indirectos' => 'array',
        'costo_total' => 'float',
        'costo_unitario' => 'float',
    ];

    public function corporativo()
    {
        return $this->belongsTo(Corporativo::class);
    }

    protected static function booted(): void
    {
        static::creating(function (self $hoja) {
            if (empty($hoja->uuid)) {
                $hoja->uuid = \Illuminate\Support\Str::uuid()->toString();
            }
        });
    }
}
