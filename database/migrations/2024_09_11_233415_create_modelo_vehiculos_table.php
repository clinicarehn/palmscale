<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modelo_vehiculos', function (Blueprint $table) {
            $table->id();  // Llave primaria de la tabla
            $table->unsignedBigInteger('idVehiculo');  // Definir la columna de clave foránea
            $table->string('modelo_detalle');
            $table->timestamps();

            // Definir la relación de clave foránea sin acción en cascada
            $table
                ->foreign('idVehiculo')
                ->references('id')
                ->on('vehiculos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelo_vehiculos');
    }
};
