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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');

            $table->string('estadotapa')->nullable();
            $table->string('apertura')->nullable();
            
            $table->string('drenaje')->nullable();
            $table->string('estadoci')->nullable();
            $table->boolean('aro')->nullable();
            $table->boolean('paredes')->nullable();
            $table->boolean('solera')->nullable();
            $table->string('condicion')->nullable();
            $table->string('sedimento')->nullable();
            $table->double('alturasedi')->nullable();
            $table->string('estadosol')->nullable();
            $table->string('escalon')->nullable();
            $table->string('estadofis')->nullable();
            $table->text('observacion')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('camara_id')->nullable();
            $table->foreign('camara_id')->references('id')->on('camaras');
            $table->timestamps();

            //tipo (entrada/salida)
            //codigo (entrada/salida)
            //gestion (entrada/salida)
            //diametro (entrada/salida)
            //material (entrada/salida)
            //profundidad (entrada/salida)
            //origen (entrada/salida)
            //destino (entrada/salida)

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
