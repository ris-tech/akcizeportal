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
        Schema::create('klienti', function (Blueprint $table) {
            $table->id();
            $table->string('naziv', 128);
            $table->string('pib', 10);
            $table->string('maticni_broj', 10);
            $table->string('ulica', 64);
            $table->string('broj_ulice', 64);
            $table->string('postanski_broj', 64);
            $table->string('mesto', 64);
            $table->string('opstina', 64);
            $table->unsignedBigInteger('odgovorno_lice_id', 64);
            $table->string('broj_ugovora', 7)->nullable();
            $table->date('datum_ugovora')->nullable();
            $table->date('pocetak_obrade');
            $table->unsignedBigInteger('poreska_filijala_id');
            $table->unsignedBigInteger('banka_id');
            $table->string('broj_bankovog_racuna', 30);
            $table->char('cena', 2);
            $table->string('pep_obrazac', 128)->nullable();
            $table->boolean('prioritet');
            $table->timestamps();

            $table->foreign('odgovorno_lice_id')->references('id')->on('odgovorno_lice');
            $table->foreign('poreska_filijala_id')->references('id')->on('poreska_filijala');
            $table->foreign('banka_id')->references('id')->on('banke');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klientis');
    }
};
