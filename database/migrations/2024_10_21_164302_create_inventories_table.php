<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idDescriptionParts');  // Clave foránea
            $table->decimal('initial_balance', 15, 2)->default(0);  // Saldo inicial en decimales
            $table->decimal('entries', 15, 2)->default(0);  // Entradas al inventario en decimales
            $table->decimal('exits', 15, 2)->default(0);  // Salidas del inventario en decimales
            $table->decimal('current_balance', 15, 2)->default(0);  // Saldo actual en decimales
            $table->decimal('final_balance', 15, 2)->default(0);  // Saldo final en decimales
            $table->timestamps();

            // Relación con description_parts
            $table->foreign('idDescriptionParts')->references('id')->on('description_parts');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};