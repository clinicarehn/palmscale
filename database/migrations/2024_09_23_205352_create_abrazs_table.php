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
        Schema::create('abrazs', function (Blueprint $table) {
            $table->id();
            $table->decimal('ANCHOmm', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('GRUESOmm', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('ANCHOmm_Lookup', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('GRUESOmm_Lookup', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos2', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos3', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos4', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos5', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos6', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos7', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos8', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos9', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos10', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos11', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos12', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos13', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos14', 18, 2);  // Esto creará un VARCHAR(255)
            $table->decimal('Pos15', 18, 2);  // Esto creará un VARCHAR(255)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abrazs');
    }
};
