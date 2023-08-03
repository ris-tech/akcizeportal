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
        Schema::create('knjigovodja', function (Blueprint $table) {
            $table->id();
            $table->string('naziv', 128);
            $table->string('ulica', 128)->nullable();
            $table->string('broj_ulice',  10)->nullable();
            $table->string('postanski_broj', 10)->nullable();
            $table->string('mesto', 64)->nullable();
            $table->string('telefon', 20);
            $table->string('email', 128)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knjigovodja');
    }
};
