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
            $table->string('bindDoc', 2048)->nullable()->after('vezni_dokument');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izvestaj_o_placanju', function (Blueprint $table) {
            //
        });
    }
};
