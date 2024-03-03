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
        Schema::create('nv_iznosi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nalog_id');
            $table->string('br_fakture');
            $table->char('kupljeno', 255);
            $table->timestamps();
            
            $table->foreign('nalog_id')->references('id')->on('nalozi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nv_iznosi');
    }
};
