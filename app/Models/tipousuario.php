<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
