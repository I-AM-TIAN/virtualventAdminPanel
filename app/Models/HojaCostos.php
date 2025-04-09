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
    ];

    protected $casts = [
        'materiales' => 'array',
        'labores' => 'array',
        'indirectos' => 'array',
        'costo_total' => 'float',
        'costo_unitario' => 'float',
    ];
}
