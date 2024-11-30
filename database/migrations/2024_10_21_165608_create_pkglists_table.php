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
        Schema::create('pkglists', function (Blueprint $table) {
            $table->id();
            $table->string('no_contact', 50)->nullable();
            $table->string('steel_grande', 50)->nullable();
            $table->string('pkg_Standard', 50)->nullable();
            $table->decimal('DIA', 8, 2)->nullable();
            $table->decimal('pkg_Lenght', 8, 2)->nullable();
            $table->decimal('pkg_Weight', 8, 2)->nullable();
            $table->integer('pkg_Bars')->nullable();
            $table->string('pkg_Bundles', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkglists');
    }
};
