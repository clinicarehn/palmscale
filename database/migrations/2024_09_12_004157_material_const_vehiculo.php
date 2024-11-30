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
        Schema::create('material_const_vehiculos', function (Blueprint $table) {
            $table->id(); // Crea una columna de clave primaria
            $table->string('no_mat', 5)->charset('utf8'); // Esto crea un VARCHAR(MAX)
            $table->string('width_plg', 10)->charset('utf8'); // Esto crea un VARCHAR(MAX)
            $table->string('thick_plg', 10)->charset('utf8'); // Esto crea un VARCHAR(MAX)
            $table->string('width_mm', 10)->charset('utf8'); // Esto crea un VARCHAR(MAX)
            $table->string('thick_mm', 10)->charset('utf8'); // Esto crea un VARCHAR(MAX)
            $table->string('Grueso', 10)->charset('utf8'); // Esto crea un VARCHAR(MAX)
            $table->string('material_combinado', 4000)->charset('utf8'); // Esto crea un VARCHAR(MAX)
            $table->timestamps(); // Crea las columnas created_at y updated_at
        });
    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_const_vehiculos'); //material_const_vehiculos
    }
};
