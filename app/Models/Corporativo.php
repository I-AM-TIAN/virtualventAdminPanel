<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Corporativo extends Model
{
    use SoftDeletes;
    //
    protected $table = 'corporativos';
    protected $fillable = [
        'nit',
        'razon_social',
        'email',
        'telefono',
        'user_id',
    ];

    public function direccion()
    {
        return $this->hasOne(Direccion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
