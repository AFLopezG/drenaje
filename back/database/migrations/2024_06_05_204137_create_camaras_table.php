<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $connection = 'pgsql';

    public function up(): void
    {
        Schema::create('camaras', function (Blueprint $table) {
            $table->id();
            $table->geometry('geom','point', 32719)->nullable();
            $table->double('lng')->nullable();
            $table->double('lat')->nullable();
            $table->double('elevacion')->nullable();
            $table->text('ubicacion')->nullable();
            //camara
            $table->string('codigo')->unique();
            $table->double('altura')->nullable(); // altura cota solera
            $table->string('tipo')->nullable(); // con Cono, sin cono, caja
            $table->string('rasante')->nullable(); //via vereda -----
            $table->string('material')->nullable(); //concreto asfalto tierra ----
            //tapa
            $table->double('diametro')->nullable(); //tapa diametro
            $table->double('altapa')->nullable();// tapa altura
            $table->string('tiptapa')->nullable();// tipo tapa  Hierro concreto sintapa

            $table->string('estado')->default('REVISADO');
            $table->string('crokis')->nullable();
            $table->string('diagrama')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camaras');
    }
};
