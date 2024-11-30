<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('production_orden_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('production_order_id');  // Clave foránea a la tabla principal de órdenes
            $table->string('description', 255)->nullable();  // Descripción, permitiendo nulos
            $table->unsignedBigInteger('part_id');  // Clave foránea a la tabla de partes (description_parts)
            $table->integer('quantity');  // Cantidad de esta parte
            $table->timestamps();

            // Relación con la tabla production_ordens
            $table
                ->foreign('production_order_id')
                ->references('id')
                ->on('production_ordens');

            // Relación con la tabla description_parts
            $table
                ->foreign('part_id')
                ->references('id')
                ->on('description_parts');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_orden_details');
    }
};
