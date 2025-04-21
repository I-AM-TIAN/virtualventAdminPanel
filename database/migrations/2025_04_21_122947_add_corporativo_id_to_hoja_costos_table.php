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
            $table->foreignId('corporativo_id')->constrained()->after('nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoja_costos', function (Blueprint $table) {
            Schema::table('hoja_costos', function (Blueprint $table) {
                $table->dropForeign(['corporativo_id']);
                $table->dropColumn('corporativo_id');
            });
        });
    }
};
