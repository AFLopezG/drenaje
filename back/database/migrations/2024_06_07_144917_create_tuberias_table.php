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
        Schema::create('tuberias', function (Blueprint $table) {
            $table->id();
            $table->geometry('geom',32719)->nullable();
            $table->string('codigo')->nullable();
            $table->string('gestion')->nullable(); 
            $table->string('diametro')->default(0);
            $table->string('material')->nullable();
            $table->double('profundidad')->default(0);
            $table->double('longitud')->default(0);

            $table->unsignedBigInteger('origen_id')->nullable();
            $table->foreign('origen_id')->references('id')->on('camaras');
            $table->unsignedBigInteger('destino_id')->nullable();
            $table->foreign('destino_id')->references('id')->on('camaras');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuberias');
    }
};
