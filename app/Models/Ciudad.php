<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ciudad extends Model
{
    //
    protected $table = 'ciudades';
    protected $fillable = ['nombre', 'departamento_id'];

    protected static function booted(): void
    {
        static::creating(function (self $ciudad) {
            if (empty($ciudad->uuid)) {
                $ciudad->uuid = Str::uuid()->toString();
            }
        });
    }
}
