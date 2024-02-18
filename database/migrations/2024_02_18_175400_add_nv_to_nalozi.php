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
        Schema::table('nalozi', function (Blueprint $table) {
            $table->unsignedBigInteger('skener_ulazne_fakture_nv_id')->after('skener_ulazne_fakture_id')->default(1);
            $table->boolean('sken_ulazne_fakture_nv')->after('sken_ulazne_fakture')->default(false);

            $table->foreign('skener_ulazne_fakture_nv_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nalozi', function (Blueprint $table) {
            //
        });
    }
};
