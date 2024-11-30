<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('production_ordens', function (Blueprint $table) {
            $table->id();
            $table->string('numero_orden', 20);
            $table->unsignedBigInteger('status_id')->default(1);  // Clave foránea para el estado con valor predeterminado
            $table->dateTime('production_date');  // Campo para la fecha de producción
            $table->timestamps();

            // Relación con statuses
            $table
                ->foreign('status_id')
                ->references('id')
                ->on('statuses');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_ordens');
    }
};
