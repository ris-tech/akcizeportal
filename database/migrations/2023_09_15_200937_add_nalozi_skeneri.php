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
            $table->unsignedBigInteger('skener_ulazne_fakture')->after('skener_id');
            $table->unsignedBigInteger('skener_izlazne_fakture')->after('skener_ulazne_fakture');
            $table->unsignedBigInteger('skener_izvodi')->after('skener_izlazne_fakture');
            $table->unsignedBigInteger('skener_analiticke_kartice')->after('skener_izvodi');
            $table->unsignedBigInteger('skener_licenca')->after('skener_analiticke_kartice');
            $table->unsignedBigInteger('skener_saobracajna')->after('skener_licenca');
            $table->unsignedBigInteger('skener_depo_karton')->after('skener_saobracajna');
            $table->unsignedBigInteger('skener_kompenzacije')->after('skener_depo_karton');
            $table->unsignedBigInteger('skener_knjizna_odobrenja')->after('skener_kompenzacije');
            $table->dropForeign('nalozi_skener_id_foreign');
            $table->dropColumn('skener_id');
            $table->dropColumn('sken_gotov');

            $table->foreign('skener_ulazne_fakture')->references('id')->on('users');
            $table->foreign('skener_izlazne_fakture')->references('id')->on('users');
            $table->foreign('skener_izvodi')->references('id')->on('users');
            $table->foreign('skener_analiticke_kartice')->references('id')->on('users');
            $table->foreign('skener_licenca')->references('id')->on('users');
            $table->foreign('skener_saobracajna')->references('id')->on('users');
            $table->foreign('skener_depo_karton')->references('id')->on('users');
            $table->foreign('skener_kompenzacije')->references('id')->on('users');
            $table->foreign('skener_knjizna_odobrenja')->references('id')->on('users');
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
