<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class tipoUsuario extends Model
{
    use SoftDeletes;

    protected $table = 'tipousuarios';

    protected $fillable = [
        'codigo',
        'nombre'
    ];

    public function hasUsers()
    {
        return $this->hasMany(User::class, 'tipo_usuario_id');
    }

    /**
     * Boot method to generate UUID when creating a new model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $tipousuario) {
            if (empty($tipousuario->uuid)) {
                $tipousuario->uuid = Str::uuid()->toString();
            }
        });
    }
}
