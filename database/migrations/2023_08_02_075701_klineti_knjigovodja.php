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
        Schema::table('klienti', function (Blueprint $table) {
            
            $table->unsignedBigInteger('knjigovodja_id')->after('poreska_filijala_id');

            $table->foreign('knjigovodja_id')->references('id')->on('knjigovodja');
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
