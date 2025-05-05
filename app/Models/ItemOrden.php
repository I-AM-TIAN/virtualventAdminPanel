<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ItemOrden extends Model
{
    protected $table = 'item_orden';
    protected $fillable = ['cantidad', 'precio', 'producto_id','orden_id'];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    /**
     * Boot method to generate UUID when creating a new model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $itemorden) {
            if (empty($itemorden->uuid)) {
                $itemorden->uuid = Str::uuid()->toString();
            }
        });
    }
}
