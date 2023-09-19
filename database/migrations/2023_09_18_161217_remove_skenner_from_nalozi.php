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
            $table->dropForeign('nalozi_skener_analiticke_kartice_foreign');
            $table->dropForeign('nalozi_skener_licenca_foreign');
            $table->dropForeign('nalozi_skener_saobracajna_foreign');
            $table->dropForeign('nalozi_skener_depo_karton_foreign');
            $table->dropColumn('skener_analiticke_kartice_id');
            $table->dropColumn('skener_licenca_id');
            $table->dropColumn('skener_saobracajna_id');
            $table->dropColumn('skener_depo_karton_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nalzi', function (Blueprint $table) {
            //
        });
    }
};
