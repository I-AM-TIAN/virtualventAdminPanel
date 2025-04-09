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
        Schema::create('hoja_costos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedInteger('cantidad');
            $table->decimal('margen',2,2)->default(0); 
            $table->json('materiales');
            $table->json('labores');
            $table->json('indirectos');
            $table->decimal('costo_total', 10, 2)->default(0);
            $table->decimal('costo_unitario', 10, 4)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_costos');
    }
};
