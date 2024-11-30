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
        Schema::create('buje_l_l_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idbujeRBNum');  // Definir la columna de clave foránea
            $table->string('dim_a', 10)->nullable();
            $table->string('dim_b', 10)->nullable();
            $table->string('dim_c', 10)->nullable();
            $table->string('dim_d', 10)->nullable();
            $table->string('remarks', 20)->nullable();
            $table->string('picture')->nullable();
            $table->timestamps();

            // Definir la relación de clave foránea sin acción en cascada
            $table->foreign('idbujeRBNum')
                ->references('id')
                ->on('buje_r_b_s');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buje_l_l_s');
    }
};