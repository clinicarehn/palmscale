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
        Schema::create('material_grapas', function (Blueprint $table) {
            $table->id();
            $table->string('inches', 10)->nullable();
            $table->string('decimal', 10)->nullable();
            $table->string('mm', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_grapas');
    }
};