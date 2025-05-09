<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pipelines', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');  // entrada / saliada
            $table->string('funcion')->nullable();
            $table->string('gestion')->nullable();
            $table->string('diametro');
            $table->string('material')->nullable();
            $table->double('profundidad')->nullable();
            $table->string('origen');
            $table->string('destino');
            $table->unsignedBigInteger('sewer_id')->nullable();
            $table->foreign('sewer_id')->references('id')->on('sewers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pipelines');
    }
};
