<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Orden extends Model
{
    protected $table = 'ordenes';
    protected $fillable = ['total', 'num_items','pagado','fecha_pago'];

    protected $casts = [
        'fecha_pago' => 'date',
        'pagado' => 'boolean', // buena práctica también
    ];

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


    public function item_orden()
    {
        return $this->hasMany(ItemOrden::class);
    }
}
