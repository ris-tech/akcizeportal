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
            $table->boolean('sken_ulazne_fakture')->default(false)->after('sken_gotov');
            $table->boolean('sken_izlazne_fakture')->default(false)->after('sken_ulazne_fakture');
            $table->boolean('sken_izvodi')->default(false)->after('sken_izlazne_fakture');
            $table->boolean('sken_analiticke_kartice')->default(false)->after('sken_izvodi');
            $table->boolean('sken_licenca')->default(false)->after('sken_analiticke_kartice');
            $table->boolean('sken_saobracajna')->default(false)->after('sken_licenca');
            $table->boolean('sken_depo_karton')->default(false)->after('sken_saobracajna');
            $table->boolean('sken_kompenzacije')->default(false)->after('sken_depo_karton');
            $table->boolean('sken_knjizna_odobrenja')->default(false)->after('sken_kompenzacije');
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
