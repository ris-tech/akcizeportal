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
        Schema::table('fajlovi', function (Blueprint $table) {
            $table->unsignedBigInteger('banka_id')->after('tip')->nullable();

            $table->foreign('banka_id')->references('id')->on('banke');
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
