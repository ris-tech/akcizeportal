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
        Schema::create('pozicije', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nalog_id');
            $table->date('datum_fakture');
            $table->string('broj_fakture');
            $table->string('gorivo');
            $table->unsignedBigInteger('dobavljac_id')->nullable();
            $table->char('iznos')->nullable();
            $table->char('kolicina');
            $table->string('vozila');
            $table->timestamps();

            $table->foreign('nalog_id')->references('id')->on('nalozi');
            $table->foreign('dobavljac_id')->references('id')->on('dobavljaci');
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
