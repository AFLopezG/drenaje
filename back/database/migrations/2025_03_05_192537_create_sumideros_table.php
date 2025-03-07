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
        Schema::create('sumideros', function (Blueprint $table) {
            $table->id();
            //camara
            $table->string('material')->nullable(); //concreto asfalto tierra ----
            $table->string('tapa')->nullable(); //concreto asfalto tierra ----
            $table->string('estado')->nullable(); //concreto asfalto tierra ----
            $table->string('apertura')->nullable(); //concreto asfalto tierra ----
            //tapa
            $table->string('sedimento')->nullable();// tipo tapa  Hierro concreto sintapa
            $table->string('altsed')->nullable();// tipo tapa  Hierro concreto sintapa
            $table->string('condicion')->nullable();// tipo tapa  Hierro concreto sintapa


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
        Schema::dropIfExists('sumideros');
    }
};
