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
        Schema::create('poreska_filijala', function (Blueprint $table) {
            $table->id();
            $table->string('ime', 64);
            $table->string('ulica', 64);
            $table->string('broj_ulice', 64);
            $table->string('postanski_broj', 64);
            $table->string('mesto', 64);
            $table->unsignedBigInteger('poreska_inspektor_id');
            $table->timestamps();
            $table->foreign('poreska_inspektor_id')->references('id')->on('poreska_inspektor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poreska_filijalas');
    }
};
