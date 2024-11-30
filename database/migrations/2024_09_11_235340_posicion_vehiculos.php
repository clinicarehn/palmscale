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
        Schema::create('posicion_vehiculos', function (Blueprint $table) {
            $table->id(); // Crea una columna de clave primaria
            $table->string('posicion'); // Columna de tipo entero
            $table->timestamps(); // Crea las columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posicion_vehiculos');
    }
};
