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
        Schema::create('fajlovi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nalog_id');
            $table->string('fajl', 54);
            $table->boolean('aktivan')->default(true);;
            $table->timestamps();

            $table->foreign('nalog_id')->references('id')->on('nalozi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fajilovi');
    }
};
