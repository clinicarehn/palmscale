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
        Schema::create('ref_tensado_vehiculos', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('letra', 25);  // Esto creará un VARCHAR(255)
            $table->string('Descripcion', 25);  // Esto creará un VARCHAR(255)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_tensado_vehiculos');
    }
};
