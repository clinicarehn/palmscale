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
        Schema::create('roleo_long_vehiculos', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('milimetros', 25);  // Esto creará un VARCHAR(255)
            $table->string('pulgadas', 25);  // Esto creará un VARCHAR(255)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roleo_long_vehiculos');
    }
};
