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
        Schema::create('description_parts', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('typeid')->nullable();
            $table->unsignedBigInteger('modelid')->nullable();
            $table->string('apodo')->nullable();
            $table->unsignedBigInteger('yearid')->nullable();
            $table->unsignedBigInteger('positionid')->nullable();
            $table->string('dlttrsid')->nullable();
            $table->string('identidad')->nullable();
            $table->unsignedBigInteger('refauxid')->nullable();
            $table->unsignedBigInteger('materialgrapaid')->nullable();
            $table->unsignedBigInteger('materialid')->nullable();
            $table->string('anchomm')->nullable();
            $table->string('gruesomm')->nullable();
            $table->string('longit')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('tipohojaid')->nullable();
            $table->string('cortecm')->nullable();
            $table->string('distcccm')->nullable();
            $table->string('lccm')->nullable();
            $table->string('llcm')->nullable();
            $table->unsignedBigInteger('roleolcid')->nullable();
            $table->unsignedBigInteger('roleollid')->nullable();
            $table->string('dosroleolc')->nullable();
            $table->string('dosroleollcm')->nullable();
            $table->string('dosporcenroleo')->nullable();
            $table->string('diambocadoid')->nullable();
            $table->string('anchoteid')->nullable();
            $table->string('destajeid')->nullable();
            $table->unsignedBigInteger('porcendespunte')->nullable();
            $table->unsignedBigInteger('abraztipoid')->nullable();
            $table->unsignedBigInteger('abrazmasterid')->nullable();
            $table->string('abrazlongcm')->nullable();
            $table->unsignedBigInteger('diatcid')->nullable();
            $table->unsignedBigInteger('tiposbujesid')->nullable();
            $table->unsignedBigInteger('bujelcid')->nullable();
            $table->unsignedBigInteger('bujellid')->nullable();
            $table->unsignedBigInteger('brioid')->nullable();
            $table->string('pesokg')->nullable();
            $table->string('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('description_parts');
    }
};
