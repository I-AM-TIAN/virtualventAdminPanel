<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemOrden extends Model
{
    protected $table = 'item_orden';
    protected $fillable = ['cantidad', 'precio', 'producto_id','orden_id'];

}
