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
        Schema::create('nv_fajlovi', function (Blueprint $table) {
            $table->id();
            $table->string('faktura');
            $table->unsignedBigInteger('fajl_id');
            $table->timestamps();
            
            $table->foreign('fajl_id')->references('id')->on('fajlovi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nv_fajlovi');
    }
};
