<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = 'ordenes';
    protected $fillable = ['total', 'num_items','pagado','fecha_pago'];

    public function item_orden()
    {
        return $this->hasMany(ItemOrden::class);
    }
}
