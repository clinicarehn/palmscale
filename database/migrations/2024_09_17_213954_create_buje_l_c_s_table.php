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
        Schema::create('buje_l_c_s', function (Blueprint $table) {
            $table->id();
            $table->string('part_no', 10);
            $table->string('od_a', 10);
            $table->string('id_b', 10);
            $table->string('length_c', 10);
            $table->string('picture', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buje_l_c_s');
    }
};
