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
        Schema::create('tipo_hoja_vehiculos', function (Blueprint $table) {
            $table->id();  // Crea una columna de clave primaria
            $table->string('tipo_hoja', 4000)->charset('utf8');  // Esto crea un VARCHAR(MAX)
            $table->string('upload', 4000)->charset('utf8')->nullable();  // Esto crea un VARCHAR(MAX)
            $table->timestamps();  // Crea las columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_hoja_vehiculos');
    }
};