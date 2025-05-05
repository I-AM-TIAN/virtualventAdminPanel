<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Departamento extends Model
{
    //
    protected $table = 'departamentos';
    protected $fillable = ['nombre', 'pais_id'];

    protected static function booted(): void
    {
        static::creating(function (self $departamento) {
            if (empty($departamento->uuid)) {
                $departamento->uuid = Str::uuid()->toString();
            }
        });
    }
}
