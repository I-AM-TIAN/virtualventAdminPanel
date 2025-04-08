<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_orden', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->foreignId('producto_id')->constrained('productos');
            $table->foreignId('orden_id')->constrained('ordenes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_orden');
    }
};
