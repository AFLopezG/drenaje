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
        Schema::create('camara_tuberia', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->unsignedBigInteger('camara_id')->nullable();
            $table->foreign('camara_id')->references('id')->on('camaras');
            $table->unsignedBigInteger('tuberia_id')->nullable();
            $table->foreign('tuberia_id')->references('id')->on('tuberias');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camara_tuberia');
    }
};
