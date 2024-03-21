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
        Schema::create('saobracajne', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vozilo_id');
            $table->date('od');
            $table->date('do');
            $table->string('broj_sasije', 20);
            $table->string('fajl');
            $table->timestamps();

            $table->foreign('vozilo_id')->references('id')->on('vozila');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saobracajne');
    }
};
