<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Categoria extends Model
{
    //
    use SoftDeletes;
    protected $table = 'categorias';
    protected $fillable = ['nombre', 'descripcion', 'user_id'];
    /**
     * Boot method to generate UUID when creating a new model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $orden) {
            if (empty($orden->uuid)) {
                $orden->uuid = Str::uuid()->toString();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
