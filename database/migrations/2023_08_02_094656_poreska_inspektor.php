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
        Schema::table('poreska_inspektor', function (Blueprint $table) {
            
            $table->unsignedBigInteger('poreska_filijala_id')->after('email');

            $table->foreign('poreska_filijala_id')->references('id')->on('poreska_filijala');
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
