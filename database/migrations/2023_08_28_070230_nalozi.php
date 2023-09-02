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
        Schema::create('nalozi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('klijent_id');
            $table->unsignedBigInteger('kvartal_id');
            $table->boolean('eurodizel')->nullable();
            $table->boolean('tng')->nullable();
            $table->unsignedBigInteger('skener_id');
            $table->unsignedBigInteger('unosilac_id');
            $table->timestamps();

            $table->foreign('klijent_id')->references('id')->on('klijenti');
            $table->foreign('kvartal_id')->references('id')->on('kvartali');
            $table->foreign('skener_id')->references('id')->on('users');
            $table->foreign('unosilac_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
