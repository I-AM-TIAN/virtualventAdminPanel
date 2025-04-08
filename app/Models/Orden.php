<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = 'orden';
    protected $fillable = ['total', 'num_items','pagado','fecha_pago'];
}
