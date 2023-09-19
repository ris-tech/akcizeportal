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
        Schema::table('klijenti_dokumenta', function (Blueprint $table) {
            $table->string('broj_fajla', 32)->nullable()->after('klijent_id');
            $table->date('datum_fajla')->nullable()->after('klijent_id');
            $table->string('fajl', 64)->after('klijent_id');
            $table->string('tip', 32)->after('klijent_id');
            
            $table->removeColumn('ugovor');
            $table->removeColumn('datum_ugovora');
            $table->removeColumn('broj_ugovora');
            $table->removeColumn('pep');
            $table->removeColumn('datum_pep');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('klijenti_dokumenta', function (Blueprint $table) {
            //
        });
    }
};
