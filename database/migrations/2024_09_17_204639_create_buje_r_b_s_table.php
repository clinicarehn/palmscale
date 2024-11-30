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
        Schema::create('buje_r_b_s', function (Blueprint $table) {
            $table->id();
            $table->string('bujeRBNum', 25);  // Esto creará un VARCHAR(255)
            $table->string('dia_cpo_PI', 25);  // Esto creará un VARCHAR(255)
            $table->string('long_cpo_PI', 25);  // Esto creará un VARCHAR(255)
            $table->string('long_tot_PI', 25);  // Esto creará un VARCHAR(255)
            $table->string('dian_int_PI', 25);  // Esto creará un VARCHAR(255)
            $table->string('dia_cpo_MM', 25);  // Esto creará un VARCHAR(255)
            $table->string('long_cpo_MM', 25);  // Esto creará un VARCHAR(255)
            $table->string('long_tot_MM', 25);  // Esto creará un VARCHAR(255)
            $table->string('dian_int_MM', 25);  // Esto creará un VARCHAR(255)
            $table->string('remarks', 25)->nullable();  // Esto creará un VARCHAR(255)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buje_r_b_s');
    }
};