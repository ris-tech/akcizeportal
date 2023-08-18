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
        Schema::create('klijenti_dokumenta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('klijent_id');
            $table->string('ugovor', 54)->nullable();
            $table->string('pep', 54)->nullable();
            $table->timestamps();

            $table->foreign('klijent_id')->references('id')->on('klijenti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klijenti_dokumenta');
    }
};
