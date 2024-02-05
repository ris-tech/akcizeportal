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
        Schema::table('fajlpromene', function (Blueprint $table) {
            $table->unsignedBigInteger('nalog_id')->after('id');

            $table->foreign('nalog_id')->references('id')->on('nalozi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fajlpromene', function (Blueprint $table) {
            //
        });
    }
};
