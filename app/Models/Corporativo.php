<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
        'logo',
    ];

    public function direccion()
    {
        return $this->hasOne(Direccion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    protected static function booted(): void
    {
        static::creating(function (self $corporativo) {
            if (empty($corporativo->uuid)) {
                $corporativo->uuid = Str::uuid()->toString();
            }
        });
    }
}
