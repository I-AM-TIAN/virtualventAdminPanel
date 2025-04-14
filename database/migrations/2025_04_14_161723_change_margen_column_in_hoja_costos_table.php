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
        Schema::table('hoja_costos', function (Blueprint $table) {
            $table->decimal('margen', 6, 2)->change(); // Hasta 9999.99
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoja_costos', function (Blueprint $table) {
            $table->decimal('margen', 2, 2)->change();
        });
    }
};
