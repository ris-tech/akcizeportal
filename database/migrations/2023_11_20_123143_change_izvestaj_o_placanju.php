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
        Schema::table('izvestaj_o_placanju', function (Blueprint $table) {
            $table->unsignedBigInteger('dobavljac_id')->after('nalog_id');

            $table->foreign('dobavljac_id')->references('id')->on('dobavljaci');
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
