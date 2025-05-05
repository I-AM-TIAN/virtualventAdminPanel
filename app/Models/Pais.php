<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pais extends Model
{
    //
    protected $table = 'paises';
    protected $fillable = ['nombre'];

    /**
     * Boot method to generate UUID when creating a new model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $pais) {
            if (empty($pais->uuid)) {
                $pais->uuid = Str::uuid()->toString();
            }
        });
    }
}
