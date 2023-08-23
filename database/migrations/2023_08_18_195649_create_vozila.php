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
        Schema::create('vozila', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('klijent_id');
            $table->string('reg_broj', 9);
            $table->string('licenca', 54)->nullable();
            $table->date('od')->nullable();
            $table->date('do')->nullable();
            $table->timestamps();

            $table->foreign('klijent_id')->references('id')->on('klijenti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vozila');
    }
};
